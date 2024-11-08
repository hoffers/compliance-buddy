from configparser import ConfigParser
import json
import os
import pandas as pd
import mysql.connector
import sys
import traceback

# Read database configuration from the config file
def read_db_config(filename='config.ini', section='mysql'):
    parser = ConfigParser()
    parser.read(filename)
    
    db_config = {}
    if parser.has_section(section):
        items = parser.items(section)
        for item in items:
            db_config[item[0]] = item[1]
    return db_config

# Connect to the MySQL database
def connect_to_db(config):
    conn = mysql.connector.connect(
        host=config['host'],
        port=config['port'],
        user=config['user'],
        password=config['password'],
        database=config['database']
    )
    return conn

# Execute the initial SQL file to create the database and schema
def init_db(cursor):
    with open('initial.sql', 'r') as sql_file:
        sql_commands = sql_file.read()
        # cursor.execute(sql_commands, multi=True)
        for command in sql_commands.split(';'):
            if command.strip():
                cursor.execute(command)

# Fix some issues with names in one sheet not matching the other
def fix_framework_name(name):
    return name.replace('[', '(').replace(']', ')') \
        .replace('moerate', 'moderate').replace(' IPD', '') \
        .replace('PCI DSS', 'PCIDSS') \
        .replace('NIST\n800-218\nv1.1', 'NIST\n800-218\nv1.1\nSSDF')

# Insert frameworks data into the database
def insert_frameworks(cursor, frameworks_df):
    all_data = []
    for _, row in frameworks_df.iterrows():
        # Skip this one that appears to be a mistake
        if row['Mapping Column Header'] == 'NIST\nSSDF':
            continue
        short_name = fix_framework_name(row['Mapping Column Header']).replace('\n', ' ').strip()
        geography = row['Geography']
        if geography in short_name:
            short_name = short_name.replace(geography, '').strip('- ')
        
        all_data.append((
            row['Source'], 
            row['Version'] if row['Version'] != 'N/A' else None,
            row['URL - Authoritative Source'], 
            short_name,
            row['Geography'], 
            row['Authoritative Source - Statutory / Regulatory / Contractual / Industry Framework'],
            fix_framework_name(row['Mapping Column Header'])
        ))
    
    query = """
    INSERT INTO frameworks (source, version, url, short_name, geography, full_name, identifier)
    VALUES (%s, %s, %s, %s, %s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Insert domains data
def insert_domains(cursor, domains_df):
    all_data = []
    for _, row in domains_df.iterrows():
        all_data.append((
            row['SCF Identifier'].strip(), 
            row['SCF Domain'], 
            row['Cybersecurity & Data Privacy by Design (C|P) Principles'], 
            row['Principle Intent']
        ))
    query = """
    INSERT INTO domains (identifier, name, principles, intent)
    VALUES (%s, %s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Determine pptdf_applicability based on columns
def determine_pptdf_applicability(row):
    if row['PPTDF\nApplicability\n\nPEOPLE'] == 'x':
        return 'People'
    if row['PPTDF\nApplicability\n\nPROCESS'] == 'x':
        return 'Process'
    if row['PPTDF\nApplicability\n\nTECHNOLOGY'] == 'x':
        return 'Technology'
    if row['PPTDF\nApplicability\n\nDATA'] == 'x':
        return 'Data'
    if row['PPTDF\nApplicability\n\nFACILITY'] == 'x':
        return 'Facility'
    return None

# Insert controls data
def insert_controls(cursor, controls_df, domain_id_map):
    all_data = []
    for _, row in controls_df.iterrows():
        # Skip this deprecated one
        if row['SCF #'] == 'TDA-11.2':
            continue

        all_data.append((
            domain_id_map[row['SCF #'][:3]],
            row['SCF #'], 
            row['SCF Control'], 
            row['Secure Controls Framework (SCF)\nControl Description'],
            row['Possible Solutions & Considerations\nMicro-Small Business (<10 staff)\nBLS Firm Size Classes 1-2'],
            # row['Methods To Comply With SCF Controls'],
            row['Relative Control Weighting'],
            determine_pptdf_applicability(row), # Based on multiple columns
            row['NIST CSF\nFunction Grouping']
        ))

    query = """
    INSERT INTO controls (domain_id, identifier, name, description, methods, weight, pptdf_applicability, nist_csf_function_grouping)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Insert controls data
def insert_questions(cursor, controls_df, control_id_map):
    all_data = []
    for _, row in controls_df.iterrows():
        # Skip this deprecated one
        if row['SCF #'] not in control_id_map:
            continue

        all_data.append((
            control_id_map[row['SCF #']],
            row['SCF Control Question'], 
            row['C|P-CMM 0\nNot Performed'], 
            row['C|P-CMM 1\nPerformed Informally'], 
            row['C|P-CMM 2\nPlanned & Tracked'], 
            row['C|P-CMM 3\nWell Defined'], 
            row['C|P-CMM 4\nQuantitatively Controlled'], 
            row['C|P-CMM 5\nContinuously Improving']
            # row['SP-CMM 0\nNot Performed'], 
            # row['SP-CMM 1\nPerformed Informally'], 
            # row['SP-CMM 2\nPlanned & Tracked'], 
            # row['SP-CMM 3\nWell Defined'], 
            # row['SP-CMM 4\nQuantitatively Controlled'], 
            # row['SP-CMM 5\nContinuously Improving']
        ))

    # Insert questions data
    query = """
    INSERT INTO questions (control_id, question, level_0, level_1, level_2, level_3, level_4, level_5)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Insert control_framework data (many-to-many mapping)
def insert_control_framework(cursor, controls_df, control_id_map, framework_id_map):
    all_data = []
    for framework_mapping, framework_id in framework_id_map.items():
        if framework_mapping in controls_df:
            # print('mapping framework: ' + str(framework_id) + ' - ' + framework_mapping.replace('\n', ' '))
            for _, row in controls_df.iterrows():
                # Skip this deprecated one
                if row['SCF #'] == 'TDA-11.2':
                    continue
                if row[framework_mapping] is not None and row[framework_mapping] != '':
                    # print('---- inserting control: ' + row['SCF #'])
                    framework_references = str(row[framework_mapping]).strip().replace('\n', ',').split(',')
                    all_data.append((
                        control_id_map[row['SCF #']], 
                        framework_id,
                        json.dumps([str(string).strip() for string in framework_references])
                    ))
        else:
            # print(f"Error: {framework_mapping} missing in controls list")
            continue

    query = """
    INSERT INTO control_framework (control_id, framework_id, framework_references)
    VALUES (%s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Insert evidence requests data
def insert_evidence_requests(cursor, evidence_requests_df):
    all_data = []
    for _, row in evidence_requests_df.iterrows():
        all_data.append((
            row['ERL #'].strip(),
            row['Area of Focus'], 
            row['Documentation Artifact'], 
            row['Artifact Description']
        ))

    query = """
    INSERT INTO evidence_requests (identifier, area, artifact, description)
    VALUES (%s, %s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Insert control_framework data (many-to-many mapping)
def insert_control_evidence_request(cursor, evidence_requests_df, control_id_map, evidence_request_id_map):
    all_data = []
    for _, row in evidence_requests_df.iterrows():
        evidence_request_id = evidence_request_id_map[row['ERL #'].strip()]

        control_mappings = row['SCF Control Mappings'].split('\n')
        for control in control_mappings:
            all_data.append((
                control_id_map[control.strip()], 
                evidence_request_id
            ))

    query = """
    INSERT INTO control_evidence_request (control_id, evidence_request_id)
    VALUES (%s, %s)
    """
    cursor.executemany(query, all_data)

# Insert assessment_objectives data
def insert_assessment_objectives(cursor, assessment_objectives_df, control_id_map):
    all_data = []
    for _, row in assessment_objectives_df.iterrows():
        # Skip this deprecated one
        if row['SCF #'].strip() not in control_id_map:
            continue
        all_data.append((
            control_id_map[row['SCF #'].strip()],
            row['SCF AO #'].strip(), 
            row['SCF Assessment Objective (AO)\nIn addition to relevant policies, standards and procedures, the assessor shall examine, interview, and/or test to determine if appropriately scoped evidence exists to support the claim that:']
        ))

    query = """
    INSERT INTO assessment_objectives (control_id, identifier, description)
    VALUES (%s, %s, %s)
    """
    cursor.executemany(query, all_data)

# Insert control_framework data (many-to-many mapping)
def get_identifier_id_map(cursor, table):
    cursor.execute(f'SELECT identifier, id FROM {table}')
    result = cursor.fetchall()
    return dict(result)

# Main script to load data into the database
def main():

    if len(sys.argv) != 2:
        print('Please include path to SCF file')
        return

    # Load Excel data
    # file_path = '../Mapping Resources/Secure Controls Framework (SCF) - 2024.3.xlsx'
    file_path = sys.argv[1]
    if not os.path.isfile(file_path):
        print("Incorrect file path:", file_path)
        return
    
    # Load the data from the spreadsheet
    domains_df = pd.read_excel(file_path, sheet_name=0, na_filter=False).replace({'▪': '-', '∙': '-'}, regex=True)
    frameworks_df = pd.read_excel(file_path, sheet_name=1, na_filter=False).replace({'▪': '-', '∙': '-'}, regex=True)
    controls_df = pd.read_excel(file_path, sheet_name=2, na_filter=False).replace({'▪': '-', '∙': '-'}, regex=True)
    assessment_objectives_df = pd.read_excel(file_path, sheet_name=3).replace({'▪': '-', '∙': '-'}, regex=True)
    evidence_requests_df = pd.read_excel(file_path, sheet_name=4, na_filter=False).replace({'▪': '-', '∙': '-'}, regex=True)

    # Read database config
    db_config = read_db_config()

    # Connect to MySQL
    conn = connect_to_db(db_config)
    cursor = conn.cursor()

    try:
        # First create the db
        # print('creating database...', end='', flush=True)
        # init_db(cursor)
        # conn.commit()
        # print('done')

        # cursor.execute("USE buddy")

        # Raise max_allowed_packet to handle bulk queries
        cursor.execute("SHOW VARIABLES LIKE 'max_allowed_packet'")
        max_allowed_packet = cursor.fetchone()[1]
        # print('max_allowed_packet', max_allowed_packet)
        cursor.execute("SET GLOBAL max_allowed_packet=1073741824") # Set to 1GB
        conn.commit()

        print('inserting frameworks...', end='', flush=True)
        insert_frameworks(cursor, frameworks_df)
        print('done')
        framework_id_map = get_identifier_id_map(cursor, 'frameworks')

        print('inserting domains...', end='', flush=True)
        insert_domains(cursor, domains_df)
        print('done')
        domain_id_map = get_identifier_id_map(cursor, 'domains')
        
        print('inserting controls...', end='', flush=True)
        insert_controls(cursor, controls_df, domain_id_map)
        print('done')
        control_id_map = get_identifier_id_map(cursor, 'controls')
        
        print('inserting control-framework mapping...', end='', flush=True)
        insert_control_framework(cursor, controls_df, control_id_map, framework_id_map)
        print('done')

        print('inserting evidence_requests...', end='', flush=True)
        insert_evidence_requests(cursor, evidence_requests_df)
        evidence_request_id_map = get_identifier_id_map(cursor, 'evidence_requests')
        print('done')
        
        print('inserting control-evidence_request mapping...', end='', flush=True)
        insert_control_evidence_request(cursor, evidence_requests_df, control_id_map, evidence_request_id_map)
        print('done')
        
        print('inserting questions...', end='', flush=True)
        insert_questions(cursor, controls_df, control_id_map)
        print('done')

        print('inserting assessment_objectives...', end='', flush=True)
        insert_assessment_objectives(cursor, assessment_objectives_df, control_id_map)
        print('done')

        cursor.execute(f"SET GLOBAL max_allowed_packet={max_allowed_packet}") # Set back
        
        # Commit the transaction
        conn.commit()
    except Exception as e:
        print(f"Error: {e}")
        traceback.print_exc()
        conn.rollback()
    finally:
        cursor.close()
        conn.close()

if __name__ == '__main__':
    main()

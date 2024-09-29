# compliance-buddy
Compliance Buddy application built for Georgia Tech OMSCY Practicum

## Setup database

1. Copy example_config.ini to config.ini and update it with connection information to your MySQL database server
2. Download the Secure Controls Framework Excel spreadsheet from https://securecontrolsframework.com/scf-download/ (Current support for version 2024-2-1)
3. Install python3, pip3, and the required packages:
```
pip3 install pandas mysql-connector-python configparser openpyxl
```
4. Run the script:
```
python3 load_scf_data.py
```

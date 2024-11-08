# Compliance Buddy
Compliance Buddy web application built for Georgia Tech OMSCY Practicum

## Setup database

1. Copy example_config.ini to config.ini and update it with connection information to your MySQL database
2. Download the Secure Controls Framework Excel spreadsheet from https://github.com/securecontrolsframework/securecontrolsframework/tree/main (Current support for version 2024.3)
3. Install python3, pip3, and the required packages:
```
pip3 install pandas mysql-connector-python configparser openpyxl
```
4. Run the script:
```
python3 load_scf_data.py '/path/to/scf file/Secure Controls Framework (SCF) - 2024.3.xlsx'
```

## Deploy API

1. Copy `api/.env.example` to `.env` and update it with your database connection information
2. Follow Laravel's deployment documentation: https://laravel.com/docs/11.x/deployment

## Deploy UI

1. Update `VITE_AXIOS_BASE_URL` to your API's URL in `spa/.env`
2. In `spa` run `npm build`
3. Upload files in `dist` folder to your web server
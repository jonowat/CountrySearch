# Jonathan Watkins
## PHP Developer Code Test for BigChoice

## Installation
1. Install new instance of Laravel.
    1. With current repository run 
        ````
        composer update
        ````  
    2. Current zip contains all dependencies
2. Create new mysql database:
   ````
    CREATE SCHEMA `bigchoice` ;
    `````
3. Rename `.env.example` to `.env` and update `.env` file with the connection details to the database.
4. Run migrations to create the databases
   ```
   php artisan migrate
   ```
5. Laravel has a built in development server
   ````
   php artisan serve
   ````
   otherwise, serve the code accordingly to the /public directory.

The main controller is the CountryController.

## Files
I have created the following files
- \App
  - \Actions
    - RetrieveFromApi.php
    - RetrieveFromDb.php
    - StoreCountry.php
  - \Http\Controllers
    - CountryCountroller.php
  - \Utilities
    - Curl.php
  - Country.php
  - Currency.php
  - Dialingcode.php
  - Language.php
  - Timezone.php
- \database\migrations
  - 2019_09_08_083021_create_countries_table.php
  - 2019_09_08_092100_create_languages_table.php
  - 2019_09_08_093854_create_timezones_table.php
  - 2019_09_08_083907_create_currencies_table.php
  - 2019_09_08_092633_create_dialingcodes_table.php
- \resources\views
  - results.blade.php
  - searchForm.blade.php
  - welcome.blade.php
- \routes
  - web.php

Other files are framework files, there by default on installation.

## Assumptions
- Searching for more than one field will `OR` search each value
- If a DB search returns at least one country it will not check the API for completeness, e.g. if on a fresh DB currency: EUR is searched, followed by a search for currency: GBP, only Zimbabwe will be returned. Searching for Country code: GB followed by currenct: GBP will then return Great Britain and Zimbabwe.
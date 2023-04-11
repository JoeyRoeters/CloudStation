- sudo pecl install mongodb; if you get an error error: 'pcre2.h' file not found then move pcre2.h to the required folder in the error
- put in php.ini: extension=mongodb.so
- put in .env file: MONGODB_DATABASE=cloud_station
- import mysql_iwa_database_for_mongo_import.sql into your mysql database
- go to route /import-mysql-to-mongo to import mysql data to mongo


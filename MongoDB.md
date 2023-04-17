- sudo pecl install mongodb; if you get an error error: 'pcre2.h' file not found then move pcre2.h to the required folder in the error
- put in php.ini: extension=mongodb.so
- put in .env file: MONGODB_DATABASE=cloud_station
- import mysql_iwa_database_for_mongo_import.sql into your mysql database
- go to route /import-mysql-to-mongo to import mysql data to mongo

mongoimport --db=cloudstation --collection countries --file ./storage/app/mongodb/countries.json --jsonArray

mongoimport --db=cloudstation --collection geolocations --file ./storage/app/mongodb/geolocations.json --jsonArray

mongoimport --db=cloudstation --collection nearst_locations --file ./storage/app/mongodb/nearest_locations.json --jsonArray

mongoimport --db=cloudstation --collection stations --file ./storage/app/mongodb/stations.json



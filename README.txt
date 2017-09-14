A News Portal Application | September 2017

----------------------------------
Starting Project 
----------------------------------
#Unzip the zip folder, change directory to the Source directory 
cd Source

-----------------------------------
Preparing and Initializing Database
-----------------------------------
#Update the following [dbhost, dbuser, dbpass, databaseName] in DB.php

#Create Database  
php DB.php

#You may also wish to use the schema.sql file to create the database. 

#Migrate the database 
php artisan migrate

----------------------
Configuring Mailer
----------------------
#Update username and password for phpmailer library. Note: This should be a valid gmail username and password
#set MAIL_USERNAME, MAIL_PASSWORD in .env

----------------------
Start Application 
----------------------
#run project [This web-serve the project on localhost:8000]
php artisan serve 

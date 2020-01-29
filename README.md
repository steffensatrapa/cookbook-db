
# cookbook-db
## technology
 1. Frontend: Bootstrap 
 2. Backend: 
	- database: mySQL
	- application:  php 
		- template engine: smarty 
 

## installation
1. download and unzip the repository to a temporary location
2. copy all files and folder from /htdocs/ to your webspace on your webserver
3. create a mySQL database on your webserver
4. edit /lib/CrConfig.php and enter 
	- your database name and credentials
	- path to log directory if you want to log some debug information. Make sure it is located outside of your webspace.
	
5. call http://yourwebserver/setupDatabase.php

6. edit /setupUser.php and enter username, password and email for your first user. 
7. call http://yourwebserver/setupUsers.php

8. Done. Call http://yourwebserver/ to get the overview and create your first cooking recipe.


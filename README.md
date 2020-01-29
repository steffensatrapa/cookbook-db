# cookbook-db
A self hosted cooking recipe database which is accessible via computer, tabled or smartphone. No unnecessary functions, simple to use, full-text search and tags. Fitted for me and my family and who else is interested.

## why?
Because I can.  
I was annoyed from our mess of printed cooking recipes which where stored chaotically in a ring binder. From different sources, damaged punching holes, grease spots, etc. Every time I was flipping through the complete folder to find a specific recipe.  
I did not want to use the big web portals like chefkoch-de, because of massive advertising and dependence. Keep your data yours. 
Also I wanted to be able to implement my own query queries like "give my a *random* receipe with tag *main dish*".

## features
- simple to use. No unnecessary functions and bloat. 
- responsive and mobile-friendly design (using Bootstrap)
- supports tags and filter by tags
- supports full-text search
- supports users with different access rights (delete, edit)
- value, unit and description of ingredients will be automatically parsed.

## demo
Actually we are using the cookbook-db installed on our family webspace. There is a demo installation which you can test:
- **URL**: *https://rezepte-demo.satrapa.de/*
- **user**: *user*
- **password**: *password*

You can *create*, *edit* and *delete* with this user. Don't worry, the demo installation will be **reset frequently**.

## technology
 1. Frontend: Simple HTML with [Bootstrap](https://getbootstrap.com/). No extra styling.
 2. Backend: 
	- database: mySQL
	- application:  PHP
		- template engine: [Smarty](https://www.smarty.net/) (separation of business logic [PHP] from presentation [HTML].
 
 ## license
- OpenSource: GNU General Public License v3.0
 
 ## requirements
- a webspace with PHP and mySQL
- a little experience in web-administration, PHP and mySQL:

## installation
Here are the quick steps for installing. 
### files:
1. Download and unzip the repository to a temporary location.
2. Copy all files and folder from htdocs/ to your webspace on your webserver.
### database:
3. Create a mySQL database on your webserver.
4. Edit lib/CrConfig.php and enter your database name and credentials.
5. Call http://yourwebserver.net/setupDatabase.php the tables will be created.
### users:
7. Edit setupUser.php and enter username, password and email for your first user.
8. Call http://yourwebserver.net/setupUsers.php the user will be added/updated.

Done. Call http://yourwebserver.net/ to get the overview and create your first cooking recipe.

## contact me
You can write an email to *steffen* at my server *satrapa.de*.


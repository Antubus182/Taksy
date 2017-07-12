# Tasky
A javascript/php/mysql based project/task mangager that is now in Beta stage of development

Right now the project is fully functional with the exeption of user managment and setup.
The databases needs to be setup Manualy and users have to be added to the database by hand.
The calculated hash for the user password can be temporarly outputed to the login screen for this reason.

At this time, New projects can be created, tasks and subtasks added and everything can be flaged done, deleting the data when the project is marked finnished.

Comming updates will focus on the styling of the page and user management. Also the ability to edit (sub)Tasks wil be implemented shortly

The flow in this project is as follows:

first the index.php is loaded,
This page includes the login.php file
In the header, it is checked whether there is a session active, if there is the user is redirected to the personalList.php page

The login.php starts a session and will check the user credentials, if correct, the user is added to the session
and redirected to the personalList.php page.

The personalList.php page is the main page of the project. It includes the htmlBuilder.php and datacollection.php scripts.
using the credentials in config.json a connection to the database is made.
using the functions in datacollection.php an associative array with all projects, tasks and subtasks for the user is created.
This array is passed to the generatePage function of htmlBuilder.php which will build the whole page based on this data.
The html is echoed out to render in the browser.

on the page, the tasks.js javascript script handles user interaction. different buttonclicks fire different ajax requests to updateProfile.php on the server.
this php script handles database interaction, the javascript then does the appropriate html/css manipulation to the page.
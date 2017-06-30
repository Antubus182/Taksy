# Taksy
A javascript/php/mysql based project/task mangager that is still in alpha stage of development

Right now this project is not fully functioning, it fetches data from the database, based on a username en renders a page.

Also the login now just ignores the password, I need a safe/secure way to handle that.

When all that is functional I need options for users to be created and edited. At that point this would be considered beta.

After the beta maybe some other features may be added (shared projects, custom themes)

The flow in this project is as follows:

first the index.php is loaded,
This page includes the login.php file
In the header, it is checked wheter there is a session active, if there is the user is redirected to the personalList.php page

The login.php starts a session and (in the future) will check the user credentials, if correct, the user is added to the session
and redirected to the personalList.php page.

The personalList.php page is the main page of the project. It includes the htmlBuilder.php and datacollection.php scripts.
using the credentials in config.json a connection to the database is made.
using the functions in datacollection.php an associative array with all projects, tasks and subtasks for the user is created.
This array is passed to the generatePage function of htmlBuilder.php which will build the whole page based on this data.
The html is echoed out to render in the browser.

on the page, the tasks.js javascript script handles user interaction. different buttonclicks fire different ajax requests to updateProfile.php on the server.
this php script handles database interaction, the javascript then does the appropriate html/css manipulation to the page.
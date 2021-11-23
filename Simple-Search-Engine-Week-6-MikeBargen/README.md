# Peak Experience
This project was built of the template of Simple Search Engine.  

# Search UI
The search box is borrowed from [Bootstrap](https://getbootstrap.com/docs/5.1/components/navbar/#forms) Data from the search form becomes available to PHP via the $_POST variable. Key code sections to look for:
* /classes/Request.php has a search() function to check whether or not the user ran a search. It references the $_POST variable.
* /classes/Mountains.php has a findMany() function that builds a query from the user's search input. It references the Request::search() function in order to do so.

# PHP and MySQL with Bootstrap Navigation
This script demonstrates how we can access data from a MySQL database using PDO (PHP Data Objects). The code makes use of PHP Classes to keep functionality organized. It it loosely follows the Model-View-Controller (MVC) pattern. It assumes you already have a hosted copy of the [Mondial database](https://www.dbis.informatik.uni-goettingen.de/Mondial/#SQL). 

### Environment Variables

In order to connect to the database the script needs to know where it is hosted, and what your username and password are. In Replit, you can use "Secrets" (Environment Variables) to input your credentials. The PHP script makes use of the following environment variables:

* DBNAME
* HOST 
* PASSWORD 
* USERNAME

### Mapbox

If you want the map images to work, you'll need to get a mapbox token. [Sign up](https://www.mapbox.com/) for the free tier, and then store your access token in the Environment. This script assumes that you'll use the following Environment Variable.

* MAPBOX_TOKEN

You can use my token if you want but if everyone does this I'll probably run out of free hits. Here is my token for reference.

* pk.eyJ1IjoibnNpdHUiLCJhIjoiOGFZRVYtayJ9.5S6MT1zMMsPcKcrIWw1zIA 

# Beyond Replit 
If deploying elsewhere (e.g. on LAMP Server):
* Use PHP8 or higher
* Point all URLs to index.php (e.g. via .htaccess )
* Set environment variables (e.g. via .htaccess )
* Deploy to the root folder

###  About
This site was built of a template created by Harold Sikkema. For more information contact [harold.sikkema@sheridancollege.ca](mailto:harold.sikkema@sheridancollege.ca)
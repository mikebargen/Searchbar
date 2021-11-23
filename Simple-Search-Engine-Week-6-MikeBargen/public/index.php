<?php

// Loading PHP Classes 
// Our code is organized into PHP Classes (see the "classes" folder)
// Here we tell PHP to auto-load these files as needed.
// This is easier than making a long list of includes. 
spl_autoload_register(function($class_name){
    include '../classes/'.$class_name . '.php';
});
// Read more about the Standard PHP Library (SPL) AutoLoader here
// https://www.php.net/manual/en/language.oop5.autoload.php
// Here, we run a basic SELECT query to fetch some country data. 


// ROUTING
// Pick an appropriate controller depending on the user's input

// If the user is searching, find mountains. 
if (Request::search()){
  include("../controllers/properties.php"); 
}
// If a single mountain is requested, display it.
elseif (Request::property()){
  include("../controllers/property.php"); 
}
// otherwise show the homepage. 
else{
  include("../controllers/properties.php"); 
}
// feel free to add your own routing logic here.
// Here, we run a basic SELECT query to fetch some country data. 




?>
 <?php

// We will end up here only if there's a search query. 
$properties = Properties::findMany();

// To render mountains visually, we have a separate "view" script
require '../views/properties.php';

?>
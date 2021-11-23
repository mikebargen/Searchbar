<?php

// Mountain controller:
// 1. Recieves a request
// 2. Delegates data fetching
// 3. Returns a response to the view

// This controller fetches data about one particular mountain.
$property = Properties::findOne();

// To render the mountain, we have a separate "view" script
require '../views/property.php';

?>
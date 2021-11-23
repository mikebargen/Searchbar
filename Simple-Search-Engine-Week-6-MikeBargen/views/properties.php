<?php  include 'partials/header.php'; ?> 

<!-- This is the View for a list of properties.  -->

<div id="banner">
  <?php  
    require 'partials/navigation.php'; 

    $count = count($properties);
    // when listing many properties we will display a count of the results.
    echo ($count == 1)? 
      "<h1>$count Property</h1>":
      "<h1>$count Properties</h1>"; 
  ?>
</div>
<div id="properties">
  <?php
    // this "foreach" loop iterates over our query results from MySQL
    // on each iteration, a new row of data is loaded into a property object.
    foreach ($properties as $property){
      // See also: the card() function in /classes/property.php
      echo $property->card();
    }
  ?>
</div>

<?php require 'partials/footer.php'; ?>
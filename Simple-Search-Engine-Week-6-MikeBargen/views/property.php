<?php    include 'partials/header.php'; ?> 

<!-- This is the View for a Single properties.  -->

<style>
  /* Add a custom banner image for each individual properties. 
  The 1280px resolution is as high as MapBox will go.  */
  #banner {
    background-image: url(<?= $property->mapImage("1280x400"); ?>)
  }
</style>
<div id="banner">
  <?php  
    require 'partials/navigation.php'; 
    // when listing a single properties, display the name in the banner.
    echo "<h1>".$property->street."</h1>"; 
  ?>
</div>
<div id="properties">
  <?php
  // See also: the profile() function in /classes/properties.php
   echo $property->profile();
  ?>
</div>

<?php  include 'partials/footer.php'; ?>
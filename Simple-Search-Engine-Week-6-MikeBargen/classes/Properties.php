
<?php 

// The property class includes:
// 1. Static methods for querying properties in general
//   property::findMany()
//   property::findOne()
//   property::highestPeak()

// 2. Logic pertaining to individual objects of the property class
//   $property->range() 
//   $property->mapImage()
//   $property->card()
//   $property->profile()

class Properties{

  // ========================
  // 1. Static methods for querying properties in general
  // ========================
  
  // property::findMany() is called by the controller, properties.php
  static function findMany(){
    // The query has several clauses:
    // SELECT, JOIN, WHERE, GROUP BY, ORDER BY
    // Build each clause separately and then assemble (concatenate) them afterwards

    // we will store search parameters here.
    $params=[];

    // It's a good idea to curate a specific list of columns 
    // rather than using the generic asterisk *
    $select = "
      SELECT *
      FROM `properties` ";
    
       

    // If user entered search query, let's use it safely in our SQL:
    // PDO filters each search parameter for safety purposes.
    // At execution time PDO substitutes with the '?' placeholders
    if (  Request::search() ){
      // To match multiple fields we can add multiple conditions.
      // First, match the name of the property.
      // $where .= " WHERE `Name` LIKE ? ";
      // $params[] = '%'.Request::search().'%';
      // // Match also the name of the property range. 
      $where .= " WHERE `street` LIKE ? ";
      $params[] = '%'.Request::search().'%';
      $where .= " OR `city` LIKE ? ";
      $params[] = '%'.Request::search().'%';
      $where .= " OR `type` LIKE ? ";
      $params[] = '%'.Request::search().'%';

      // // Match also the name of the province.
      // $where .= " OR `price` LIKE ? ";
      // $params[] = '%'.Request::search().'%';
    }
 

    // assemble the parts of the query 
    $sql = $select.$where.$groupBy.$orderBy.$direction;

    // uncomment the var_dump below to debug your assembled SQL query. 
    // var_dump($sql);

    $query = App::pdo()->prepare($sql);
    $query->execute($params);
    // PDO's FETCH_CLASS option allows for a classname (e.g. Property) 
    // Each row thus becomes a property object (instance of property class)
    return $query->fetchAll(PDO::FETCH_CLASS, 'Properties'); 
  }

  // property::findOne() is called by the controller, property.php
  static function findOne(){
    // Notice the question mark (?) in the WHERE clause below
    // It is a placeholder whose value is added later by PDO
    // This is a more secure way to prepare a query,
    // Especially when the input hasn't been verified.
    $sql =
      "
       SELECT *
      FROM `properties` 
      WHERE `properties`.`street` = ?
      "
    ;
    // uncomment the var_dump below to debug your assembled SQL query.    
    //var_dump($sql);
    //var_dump(Request::property() );


    // Since the above query has a placeholder (?), 
    // The use of PDO's prepare() is important here
    $query = App::pdo()->prepare($sql);
    // To execute the prepared statement, 
    // Fill the placeholder (?) with whatever property the user requested.
    $query->execute([ Request::property() ]); 
    // To get a single result, use fetchObject() to return the first row only.
    // Note how we are telling PDO which class to use (property)
    return $query->fetchObject('Properties'); 
  }

  // The highestPeak is stored as a static variable.
  // It is set up this way because we only need to fetch it once. 
  public static $highestPeak = null ;
  static function highestPeak(){
    if ( self::$highestPeak ) {   return self::$highestPeak ;   }
    self::$highestPeak = 
      App::pdo()
        ->query("SELECT max(price) FROM properties")
        ->fetchColumn();
    return self::$highestPeak;
  }
 
  
  // =================================
  // 2. Code for individual objects of the property class
  // ========================


  // property constructor
  // Runs automatically on each new instance of the property class. 
  // Generates some useful derivations/variations on the available data. 
  // Note that objects created by PDO will be populated prior to __construct()
  function __construct(){ 
    // use the relative height of the property to make an alpha value.
    // note the use here of the static function property::highestPeak()
    // $alpha = round( $this->Height / property::highestPeak(), 2);
    // $this->bgColor = "rgba(124,167,180,$alpha)";
    // Generate a map image using mapbox static image API.
    $this->mapImage = $this->mapImage();
   // $this->streetLink = 'https://www.google.com/maps/@'.$this->longitude.','.$this->latitude.'15z';
    
    // "http://maps.google.com/?cbll=$this->longitude,$this->latitude&cbp=12,20.09,,0,5&layer=c";

    // Note that the Request::property() will recognize this url
    $this->link = "/properties/".urlencode($this->street);
    // Build an HTML snippet for property range where applicable.
    $this->range = $this->range();
  }
  
  function range(){
    // If this property is part of a range, 
    // it will have some data in the "properties" column
    // in that case we can build HTML markup, otherwise it will remain blank.
    if ($this->properties){
    return <<<HTML
      <h3>
        <span class="material-icons">terrain</span>
        $this->properties
      </h3>
    HTML;
    }
  }

  // Generate a map image based on this property's location (Latitude/Longitude)
  // Mapbox offers a generous free tier to make map images.
  // You are advised to get your own account and token 
  // Example:
  //  MAPBOX_TOKEN
  //  pk.eyJ1IjoibnNpdHUiLCJhIjoiOGFZRVYtayJ9.5S6MT1zMMsPcKcrIWw1zIA 
  // See also: https://docs.mapbox.com/playground/static/
  function mapImage($resolution = "800x200"){
    //  add MAPBOX_TOKEN to Replit's "Secrets" (Environment Variables)    
      $token = getenv('MAPBOX_TOKEN'); 
      return "https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/$this->longitude,$this->latitude,18,0/$resolution?access_token=$token";
  }

  // Build an HTML "card" template for each property 
  // It is called by the list view ( /views/properties.php )
  function card(){    
//var_dump($this);
    // We can use variables to show unique data  (e.g. $this->Name)
    // Variables correspond to columns from our SQL query
    return <<<HTML
        <div style="background: $this->bgColor;" class="property">
          <div class="map" style="background-image: url($this->mapImage)"></div> 
          <h2><a href="$this->link">$this->street</a></h2>
          <h3> <a href="$this->streetLink" target="_blank">StreetView</a></h3>
          
          <h3>
            <span class="material-icons">place</span>
            $this->latitude,$this->longitude</h3>
          <h3>
            <span class="material-icons">apartment</span>
            $this->city
          </h3>
          <h3>
            <span class="material-icons">flag</span>
            $this->state
          </h3>
          <h3>
            <span class="material-icons">attach_money</span>
            $this->price
          </h3> 
        </div>
    HTML;
  }

  // This profile function shows a property on its own page. 
  // It is called by the single view ( /views/property.php )
  function profile(){
    return <<<HTML
        <div style="background: $this->bgColor;" class="property">
          
          <h2><a href="$this->link">$this->street</a></h2>
          <h3> <a href="$this->streetLink" target="_blank">StreetView</a></h3>
          
          <h3>
            <span class="material-icons">place</span>
            $this->latitude,$this->longitude</h3>
          <h3>
            <span class="material-icons">apartment</span>
            $this->city
          </h3>
          <h3>
            <span class="material-icons">flag</span>
            $this->state
          </h3>
            <h3>
            <span class="material-icons">king_bed</span>
            $this->beds 
          </h3>
            <h3>
            <span class="material-icons">bathtub</span>
            $this->baths 
          </h3>
            <h3>
            <span class="material-icons">square_foot</span>
            $this->sq__ft 
          </h3>
          <h3>
            <span class="material-icons">attach_money</span>
            $this->price 
          </h3> 
        </div>
    HTML;

  }

  
}

?>

<?php

// The Request class helps us deal with User Requests 
// Note that PHP records the requested URL in a special $_SERVER variable
// See also: https://www.php.net/manual/en/reserved.variables.server.php
// The functions in this class are all "static" functions.
// Unlike propertiess, we'll only ever have one request rather than many instances. 

// The following methods are available:
// Request::url()             --get the url requested by the user
// Request::url_contains()    --check if the url contains a given string.
// Request::url_parts()       --split the url into an array of pieces


// Request::properties()        --get the user-requested properties 
// Request::search()       --get the user-requested search query

class Request{

  // get the URL requested by the user.
  // trim away any leading or trailing slashes for consistency.
  static function url(){
    return trim($_SERVER['REQUEST_URI'], '/');
  }

  // check whether the requested url contains a given string.
  static function url_contains($string){
    // Note that str_contains() is new in PHP 8
    // https://php.watch/versions/8.0/str_contains
    $url = urldecode(self::url());
    if (str_contains($url, $string)) return true;
    return false;
  }

  // split the url into an array of pieces 
  // the url string is separated at every slash. 
  // this can be helpful if you want to analyze the url
  static function url_parts(){ 
    return explode('/', self::url());
  }


  // if a user requests a properties, get the requested properties name 
  // e.g. the url  "/properties/Ampato" will return "Ampato"
  static function property(){
    if ( self::url_contains( "properties") ){
      foreach(self::url_parts() as $string){
        if ($string != "properties"){
          return urldecode($string);
        }
      }
    }
     // if the user did not ask for a properties return false. 
    return false;  
  }

    static function religion(){
    if ( self::url_contains( "religion") ){
      foreach(self::url_parts() as $string){
        if ($string != "religion"){
          return urldecode($string);
        }
      }
    }
     // if the user did not ask for a properties return false. 
    return false;  
  }

  // when the search form is submitted, 
  // the query is passed along in the $_POST variable.
  // look for the corresponding HTML markup in /partials/navigation.php
  static function search(){
    if ($_POST['q']){
      return $_POST['q'];
    }
    return false;
  }

}
?>
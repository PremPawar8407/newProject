<?php

namespace App\Mongo;
use MongoDB\Client;

class Service {
 private $mongo;

public function __construct($uri, $uriOptions, $driverOptions) {
$this->mongo = new Client($uri = null, $uriOptions = [],
$driverOptions = []);
}

public function get() {

$mongodbURI = env('MONGODB_URI');
$mongodbUsername = (env('MONGODB_USERNAME') == "") ? "" : env('MONGODB_USERNAME') . ":";
 $mongodbPassword = (env('MONGODB_PASSWORD') == "") ? "" : env('MONGODB_PASSWORD') . "@";
 $mongodbDatabase = env('MONGODB_DATABASE');
 $mongodbSSL = (env('MONGODB_SSL')) ? "true":"false";
 $mongodbAuthsource = env('MONGODB_AUTHSOURCE');
 $mongodbTryonce = (env('MONGODB_TRYONCE') == "") ?"false": "true" ;
 $mongodbSelectionTimeout = env('MONGODB_SELECTION_TIMEOUT');
 $connectionString = 'mongodb://' . $mongodbUsername . $mongodbPassword .
 $mongodbURI . '/' . $mongodbDatabase . '?ssl=' . $mongodbSSL . '&authSource=' . $mongodbAuthsource .
 '&serverSelectionTryOnce=' . $mongodbTryonce;
 if($mongodbSelectionTimeout != "")
$connectionString .= '&serverSelectionTimeoutMS='. $mongodbSelectionTimeout;

     if(env("MONGO_ISCLUSTERED")==false){
	    $connectionString="mongodb://".env("MONGODB_URI");
    }

$this->mongo = new Client($connectionString);
     return $this->mongo;
}
} ?>
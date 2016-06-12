<?php
// Get the document root
$docRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT', FILTER_SANITIZE_STRING);
// Get the application path
$uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
$dirs = explode('/', $uri);
/**
This was a galatic headache for me. I refuse to do it the way the book showed be by
Using dirs[1] dirs[2]; The following solution is better IMO
 */
// Get the location of this file C:/......final_cs6252/util/
$root = dirname(__FILE__);
// Turn it into an array of strings
$rootParts = explode("\\", $root);
// Count how many strings are in the array
$dirCount = count($rootParts);
// I am doing minus 2 because the index is 0 and the util folder counts as an index hence - 2
$appRoot = $rootParts [$dirCount - 2];
// begin constructing my application path
$appPath = '/';
foreach ($dirs as $dir) {
  if (! empty($dir)) {
    if (strcasecmp($dir, $appRoot) != 0) {
      $appPath .= $dir . "/";
    } elseif (strcasecmp($dir, $appRoot) == 0) {
      $appPath .= "$appRoot/";
      break;
    }
  }
}
// Bringing in utility files
include_once 'email_messaging.util.php';
// Set the include path
set_include_path($docRoot . $appPath);
// Common Functions
/**
 * Function for displaying application errors
 *
 * @param String $errorMessage          
 */
function display_error($errorMessage) {
  global $appPath;
  include 'errors/error.php';
  exit();
}
/**
 * Function for redirecting a user
 *
 * @param String $url
 *          URL for redirect
 */
function redirect($url) {
  session_write_close();
  header("Location: " . $url);
  exit();
}
// Get Database Connection
require_once ('model/db.cfg.php');
// Start Session
session_start();
?>
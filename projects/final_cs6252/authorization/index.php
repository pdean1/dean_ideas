<?php
/**
 * This is the controller for the authorization portion of the marketplace
 * program.
 */
// Pulling in the neccessary files to run the program
require_once '../util/app.util.php';
require_once 'util/secure_conn.util.php';
require_once 'model/user_db.php';
require_once 'model/fields.cla.php';
require_once 'model/validate.cla.php';

// session_unset();
// session_destroy();

// Determining the action for the user to take
$action = filter_input(INPUT_POST, 'action');
if ($action == false || $action == null) {
  $action = filter_input(INPUT_GET, 'action');
  if ($action == false || $action == null) {
    $action = 'view_login';
  }
}
// If the user is not attempting to logout and the user is logged in, get them out of the
// authorization folder!!!
if ($action != 'logout') {
  if (isset($_SESSION ['user'])) {
    redirect('..');
  }
}

// Creating the $fields and $validator
$validator = new Validate();
$fieldsCollection = $validator->getFields();
// For Login Form
$fieldsCollection->addField('user_password');
// For Login and Registration Form
$fieldsCollection->addField('user_email');
// For Registration Form
$fieldsCollection->addField('first_name');
$fieldsCollection->addField('last_name');
$fieldsCollection->addField('password1');
$fieldsCollection->addField('password2');
// Default value for the login error
$loginError = "";

switch ($action) {
  case 'view_login' :
    $pageTitle = "Login";
    // Reseting input elements
    $email = "";
    $password = "";
    $loginError = "";
    include 'login_form.php';
    break;
  
  case 'login' :
    // Get the values
    $email = filter_input(INPUT_POST, 'user_email');
    $password = filter_input(INPUT_POST, 'user_password');
    // Validate values
    $validator->uwgEmail('user_email', $email);
    $validator->password('user_password', $password, true, 6);
    // Show login form again if errors exist an exit the controller
    if ($fieldsCollection->hasErrors()) {
      $pageTitle = "Login Error";
      include 'authorization/login_form.php';
      break;
    }
    // Checks to see if the user exists
    if (isValidUserLogin($email, $password)) {
      $_SESSION ['user'] = getUserByEmail($email);
    } else {
      $pageTitle = "Login Error";
      $loginError = "Invalid email password combination. Please try again.";
      include 'authorization/login_form.php';
      break;
    }
    // Take the user to the application
    redirect('..');
    break;
  
  case 'view_register' :
    $pageTitle = "Register";
    // Reseting form values
    $firstName = "";
    $lastName = "";
    $email = "";
    $registerError = "";
    include 'register_form.php';
    break;
  
  case 'register' :
    // Creating the variables from the form
    $firstName = filter_input(INPUT_POST, 'first_name');
    $lastName = filter_input(INPUT_POST, 'last_name');
    $email = filter_input(INPUT_POST, 'user_email');
    $password = filter_input(INPUT_POST, 'password1');
    $passwordCheck = filter_input(INPUT_POST, 'password2');
    $registerError = "";
    // Validate Values
    if (strcmp($passwordCheck, $password) != 0) {
      $pageTitle = "Register Error";
      $registerError = "Passwords do not match please try again";
      include 'authorization/register_form.php';
      break;
    }
    $validator->text('first_name', $firstName);
    $validator->text('last_name', $lastName);
    $validator->uwgEmail('user_email', $email);
    $validator->password('user_password', $password, true, 6);
    // If the validator detected errors show register form again
    if ($fieldsCollection->hasErrors()) {
      $pageTitle = "Register Error";
      include 'authorization/register_form.php';
      break;
    }
    // See if the user already exists in the database
    if (userAlreadyExists($email)) {
      $pageTitle = "Register Error";
      $registerError = "That email already exists in the database! Try a different email.";
      include 'authorization/register_form.php';
      break;
    }
    // Create a user and retrive the ID
    $userID = createUser($firstName, $lastName, $email, $password);
    // Get the user and create a session for them
    if (! isset($_SESSION ['user'])) {
      $_SESSION ['user'] = getUser($userID);
    }
    // Creating the parts of the email
    $userName = $_SESSION ['user'] ['user_first_name'] . " " . $_SESSION ['user'] ['user_last_name'];
    $userEmail = $_SESSION ['user'] ['user_email'];
    $to = $userName . '<' . $userEmail . '>';
    $from = "Marketplace Admin <pdean@westga.edu>";
    $subject = "Thanks for Registering with UWG Marketplace";
    $body = createRegisterEmailBody($userName, $userEmail);
    $isHTML = true;
    // Sending the email
    send_email($to, $from, $subject, $body, $isHTML);
    // Redirecting to the main portion of the site
    redirect('..');
    break;
  
  case 'logout' :
    session_unset($_SESSION ['user']);
    session_unset();
    session_destroy();
    redirect('..');
    break;
  
  default :
    redirect('.');
    break;
}
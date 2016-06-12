<?php
/**
 * This file aids in getting values out of the SESSION array
 */
/**
 * Returns the user's id from the $_SESSION array
 * 
 * @return int The user's id
 */
function getUserID() {
  return $_SESSION ['user'] ['user_id'];
}

/**
 * Gets the user's first name from the $_SESSION array
 * 
 * @return string The user's first name
 */
function getUserFirstName() {
  return $_SESSION ['user'] ['user_first_name'];
}

/**
 * Gets the user's last name from the $_SESSION array
 * 
 * @return string The user's last name
 */
function getUserLastName() {
  return $_SESSION ['user'] ['user_last_name'];
}

/**
 * Gets the user's full name by combining the first and last names from the $_SESSION array
 * 
 * @return string The user's full name
 */
function getUserFullName() {
  return getUserFirstName() . " " . getUserLastName();
}

/**
 * Gets the user's email from the $_SESSION array
 * 
 * @return string The user's email
 */
function getUserEmail() {
  return $_SESSION ['user'] ['user_email'];
}

/**
 * Gets the user's photo file name from the $_SESSION array
 * 
 * @return string The user's photo file name
 */
function getUserPhoto() {
  return $_SESSION ['user'] ['user_photo'];
}

/**
 * Creates a link to the user's photo by using the getUserPhoto().
 * If no file name exists in the database then a generic user photo is displayed using the src attribute
 * of the image element
 * 
 * @return string A link to the user's photo
 */
function getUserPhotoLink() {
  global $appPath; // Needs this, it is located in app.util.php
  $photo = getUserPhoto();
  $photoLink = $appPath . "images/users/no_image.png";
  if (!empty($photo)) {
    $photoLink = $appPath . "images/users/" . $photo;
  }
  return $photoLink;
}

/**
 * Gets the user's work phone number from the database.
 * If one is not set
 * then a generic message stating 'Not yet set' will be returned
 * 
 * @return string User's workphone number
 */
function getUserWorkPhone() {
  $workPhone = $_SESSION ['user'] ['user_work_phone'];
  if (empty($workPhone)) {
    $workPhone = "Not yet set.";
  }
  return $workPhone;
}

/**
 * Gets the user's personal phone number from the database.
 * If one is not set
 * then a generic message stating 'Not yet set' will be returned
 * 
 * @return string User's personal number
 */
function getUserPersonalPhone() {
  $personalPhone = $_SESSION ['user'] ['user_personal_phone'];
  if (empty($personalPhone)) {
    $personalPhone = "Not yet set.";
  }
  return $personalPhone;
}

/**
 * Get's the user's bio from the database.
 * If one is not set a generic message will be displayed
 * 
 * @return string User's bio
 */
function getUserBio() {
  $bio = $_SESSION ['user'] ['user_bio'];
  if (empty($bio)) {
    $bio = "Not yet set.";
  }
  return $bio;
}

/**
 * Gets the date portion of the created timestamp and returns it
 * 
 * @return string The date portion of the created timestamp
 */
function getUserDateCreated() {
  return substr($_SESSION ['user'] ['created_timestamp'], 0, 10);
}

/**
 * Gets the time portion of the created timestamp and returns it
 * 
 * @return string The time portion of the created timestamp
 */
function getUserTimeCreated() {
  return substr($_SESSION ['user'] ['created_timestamp'], 11);
}

/**
 * Gets the date portion of the updated timestamp and returns it
 * 
 * @return string The date portion of the updated timestamp
 */
function getUserDateUpdated() {
  return substr($_SESSION ['user'] ['updated_timestamp'], 0, 10);
}

/**
 * Gets the time portion of the updated timestamp and returns it
 * 
 * @return string The time portion of the updated timestamp
 */
function getUserTimeUpdated() {
  return substr($_SESSION ['user'] ['updated_timestamp'], 11);
}
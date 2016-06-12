<?php
/**
 * Checks to see if the login credentials represent a valid user
 *
 * @param string $email
 *          Email of the user
 * @param string $password
 *          Password of the user
 * @return boolean True if valid, false otherwise
 */
function isValidUserLogin($email, $password) {
  global $marketplaceDB;
  $enc_password = sha1($email . $password);
  $query = 'SELECT * FROM view_users
              WHERE user_email = :email AND user_password = :password';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $enc_password);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Checks to see if a user already exists in the database
 *
 * @param string $email
 *          Email to search for
 * @return boolean true if exists, false other wise
 */
function userAlreadyExists($email) {
  global $marketplaceDB;
  $query = '
        SELECT * FROM view_users
        WHERE user_email = :email';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Get's a user by a corresponding id value
 *
 * @param int $userID
 *          The userID of the record to retrieve
 * @return array An array of user values
 */
function getUser($userID) {
  global $marketplaceDB;
  $query = 'SELECT 
			    *
              FROM view_users
			  WHERE user_id = :userID;';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Get's a user by a corresponding id value
 *
 * @param int $userID
 *          The userID of the record to retrieve
 * @return array An array of user values
 */
function getUserByEmail($email) {
  global $marketplaceDB;
  $query = 'SELECT
			    *
              FROM view_users
			  WHERE user_email = :email;';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Returns all users stored in the database
 *
 * @return array Info on all users
 */
function getUsers() {
  global $marketplaceDB;
  $query = 'SELECT 
			    user_id, user_first_name, user_last_name, user_email, 
			    user_password, user_photo, user_work_phone, user_personal_phone, 
			    user_bio, created_timestamp, updated_timestamp 
              FROM view_users;';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * A register specific function.
 * Takes in the fields from the register form and inserts them into the database
 *
 * @param String $firstName
 *          User's first name
 * @param String $lastName
 *          User's last name
 * @param String $email
 *          User's email
 * @param String $password
 *          user's password
 * @return int The id of the previously submited record
 */
function createUser($firstName, $lastName, $email, $password) {
  global $marketplaceDB;
  $enc_password = sha1($email . $password);
  $createdTimestamp = date('m/d/Y h:i:s');
  $query = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password, created_timestamp)
			  VALUES (:f_name, :l_name, :email, :p_word, :stamp);";
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':f_name', $firstName);
    $statement->bindValue(':l_name', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':p_word', $enc_password);
    $statement->bindValue(':stamp', $createdTimestamp);
    $statement->execute();
    $userID = $marketplaceDB->lastInsertId();
    $statement->closeCursor();
    return $userID;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Updates the user's values
 * 
 * @param int $userID
 *          Used to identify user to update
 * @param string $fName
 *          First name of user
 * @param string $lName
 *          Last name of user
 * @param string $email
 *          Email of user, does not change, used to create encrypted password
 * @param string $pWord
 *          New password
 * @param string $photoFileName
 *          User's associated photo's file name
 * @param string $wPhone
 *          User's work phone number
 * @param string $pPhone
 *          User's personal phone number
 * @param string $bio
 *          User's biography
 */
function updateUser($userID, $fName, $lName, $email, $pWord, $photoFileName, $wPhone, $pPhone, $bio) {
  global $marketplaceDB;
  $updatedTimestamp = date('m/d/Y h:i:s');
  if (! empty($pWord)) {
    $password = sha1($email . $pWord);
    $query = "UPDATE users
              SET user_password = :password,
                  updated_timestamp = :timestamp
              WHERE user_id = :id;";
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':timestamp', $updatedTimestamp);
    $statement->bindValue(':id', $userID);
    $success = $statement->execute();
    $statement->closeCursor();
  }
  $query = "UPDATE users
            SET user_first_name = :fName, user_last_name = :lName,
                user_photo = :photo, user_work_phone = :wPhone, 
                user_personal_phone = :pPhone, user_bio = :bio, 
                updated_timestamp = :timestamp
            WHERE user_id = :id;";
  $statement = $marketplaceDB->prepare($query);
  $statement->bindValue(':fName', $fName);
  $statement->bindValue(':lName', $lName);
  $statement->bindValue(':photo', $photoFileName);
  $statement->bindValue(':wPhone', $wPhone);
  $statement->bindValue(':pPhone', $pPhone);
  $statement->bindValue(':bio', $bio);
  $statement->bindValue(':timestamp', $updatedTimestamp);
  $statement->bindValue(':id', $userID);
  $statement->execute();
  $statement->closeCursor();
}

/**
 * Deletes a user from the database
 * 
 * @param int $userID
 *          ID of the User to be deleted
 */
function deleteUser($userID) {
  global $marketplaceDB;
  $query = 'DELETE FROM users WHERE user_id = :userID;';
  $statement = $marketplaceDB->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $statement->closeCursor();
}
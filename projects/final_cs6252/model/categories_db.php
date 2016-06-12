<?php
/**
 * Gets all catogories from the Database
 *
 * @return array An array of all categories
 */
function getCategories() {
  global $marketplaceDB;
  $query = 'SELECT * FROM view_categories;';
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
 * Returns information about a specific category
 *
 * @return array Array of info about the category
 */
function getCategory($catID) {
  global $marketplaceDB;
  $query = 'SELECT * FROM view_categories WHERE category_id = :catID;';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}
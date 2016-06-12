<?php
/**
 * This file contains functions for interacting with the products table
 */

/**
 * Gets a product based on the supplied product id
 *
 * @param string $productID
 *          Id of the product to get
 * @return array Info about the product
 */
function getProduct($productID) {
  global $marketplaceDB;
  $query = 'SELECT * FROM view_product_master WHERE product_id = :id';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':id', $productID);
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
 * Checks to see a a product is actually the user's product
 *
 * @param int $productID
 *          ID of the product to check.
 * @param int $userID
 *          ID of the User to check against
 * @return boolean True if user's product, false otherwise
 */
function isUsersProduct($productID, $userID) {
  $product = getProduct($productID);
  if ($product ['user_id'] != $userID) {
    return false;
  } else {
    return true;
  }
}

/**
 * Gets all products in the products database you can supply a category id
 * to retrieve products from that category alone
 *
 * @param int $categoryID
 *          Optional. If set it queries products based on a category
 * @return array An array of all products
 */
function getAllProducts($categoryID = "") {
  global $marketplaceDB;
  $query = 'SELECT * FROM view_product_master';
  if (! empty($categoryID)) {
    $query .= ' WHERE category_id = :id ORDER BY created_timestamp';
  } else {
    $query .= ' ORDER BY created_timestamp';
  }
  try {
    $statement = $marketplaceDB->prepare($query);
    if (! empty($categoryID)) {
      $statement->bindValue(':id', $categoryID);
    }
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Gets all products associated with the users specified with $userID
 *
 * @param int $userID
 *          ID of the user to retrieve products based on
 * @return array All products associated with a user
 */
function getProductsByUser($userID) {
  global $marketplaceDB;
  $query = 'SELECT * FROM view_product_master WHERE user_id = :id ORDER BY created_timestamp';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':id', $userID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Creates a product
 *
 * @param int $userID
 *          User ID associated with the product
 * @param string $name
 *          Product name
 * @param int $category
 *          Category of the product
 * @param string $descr
 *          Product description
 * @param double $price
 *          Price of the product
 * @param string $negotiatePrice
 *          Is the product negotiable?
 * @param string $photo
 *          Photo file name
 * @return int Returns the product id of the last created product
 */
function createProduct($userID, $name, $category, $descr, $price, $negotiatePrice) {
  global $marketplaceDB;
  $timestamp = date('m/d/Y h:i:s');
  $query = 'INSERT INTO products
             (user_id, product_name, category_id, product_descr, 
              product_price, negotiate_fg, created_timestamp, updated_timestamp)
            VALUES 
              (:uid, :pname, :cid , :pdescr , :pprice , :negotiate  , :timestamp, :ts);';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':uid', $userID);
    $statement->bindValue(':pname', $name);
    $statement->bindValue(':cid', $category);
    $statement->bindValue(':pdescr', $descr);
    $statement->bindValue(':pprice', $price);
    $statement->bindValue(':negotiate', $negotiatePrice);
    $statement->bindValue(':timestamp', $timestamp);
    $statement->bindValue(':ts', $timestamp);
    $statement->execute();
    $productID = $marketplaceDB->lastInsertId();
    $statement->closeCursor();
    return $productID;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Updates a Product
 *
 * @param int $productID          
 * @param string $name
 *          Product name
 * @param int $category
 *          Category of the product
 * @param string $descr
 *          Product description
 * @param double $price
 *          Price of the product
 * @param string $negotiatePrice
 *          Is the product negotiable?
 * @param string $photo
 *          Photo file name
 * @return int The products id
 */
function updateProduct($productID, $name, $category, $descr, $price, $negotiatePrice) {
  global $marketplaceDB;
  $timestamp = date('m/d/Y h:i:s');
  $query = "UPDATE products
            SET product_name = :pname, category_id = :cid,
                product_descr = :pdescr, product_price = :pprice,
                negotiate_fg = :negotiate,
                updated_timestamp = :timestamp
            WHERE product_id = :id;";
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':pname', $name);
    $statement->bindValue(':cid', $category);
    $statement->bindValue(':pdescr', $descr);
    $statement->bindValue(':pprice', $price);
    $statement->bindValue(':negotiate', $negotiatePrice);
    $statement->bindValue(':timestamp', $timestamp);
    $statement->bindValue(':id', $productID);
    $statement->execute();
    $statement->closeCursor();
    return $productID;
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Attaches an image to the product
 *
 * @param int $productID
 *          Product ID of the image to attach to
 * @param string $photo
 *          Name of the photo
 */
function addProductImage($productID, $photo) {
  global $marketplaceDB;
  $timestamp = date('m/d/Y h:i:s');
  $query = "UPDATE products
            SET product_photo = :photo,
                updated_timestamp = :timestamp
            WHERE product_id = :id;";
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':photo', $photo);
    $statement->bindValue(':timestamp', $timestamp);
    $statement->bindValue(':id', $productID);
    $statement->execute();
    $statement->closeCursor();
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Deletes a Product from the database
 *
 * @param int $productID
 *          ID of product to delete
 */
function deleteProduct($productID) {
  global $marketplaceDB;
  $query = 'DELETE FROM products WHERE product_id = :id;';
  try {
    $statement = $marketplaceDB->prepare($query);
    $statement->bindValue(':id', $productID);
    $statement->execute();
    $statement->closeCursor();
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    display_error($errorMessage);
  }
}

/**
 * Testing
 */
// echo createProduct(15, 'Mac Book', '1', 'Big ol Mackbook', 1200.00, 'Y', null); # Confirmed
// deleteProduct(1); # Confirmed
// echo updateProduct(2, 'Lenovo', 3, 'Ugly Lenovo', 120.00, 'N', 'Some.png'); #Confirmed
// $test = getAllProducts(); # Confirmed
// $test = getAllProducts(3); # Confirmed
// $test = getProductsByUser(15); # Confirmed
// $test = getProduct(2); # Confirmed
// print_r($test);

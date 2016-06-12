<?php
/**
 * This controller is for the account portion of the application.
 * It deals with viewing/updating account info and adding/editing listings.
 */
// Bringing in the necessary files
require_once '../util/app.util.php';
require_once 'util/secure_conn.util.php';
require_once 'util/sessions.util.php';
require_once 'util/image.util.php';
require_once 'model/user_db.php';
require_once 'model/products_db.php';
require_once 'model/categories_db.php';
require_once 'model/fields.cla.php';
require_once 'model/validate.cla.php';
// Has the user logged in yet?
if (! isset($_SESSION ['user'])) {
  redirect($appPath . 'authorization');
}
// Determining what action to take
$action = filter_input(INPUT_POST, 'action');
if ($action == false || $action == null) {
  $action = filter_input(INPUT_GET, 'action');
  if ($action == false || $action == null) {
    $action = 'view_account';
  }
}
// Page Information Reset
$pageTitle = "";
// Creating the $fields and $validator
$validator = new Validate();
$fieldsCollection = $validator->getFields();
// For Edit Account Form
$fieldsCollection->addField('first_name');
$fieldsCollection->addField('last_name');
$fieldsCollection->addField('w_phone');
$fieldsCollection->addField('p_phone');
$fieldsCollection->addField('old_pw');
$fieldsCollection->addField('new_pw1');
$fieldsCollection->addField('new_pw2');
$fieldsCollection->addField('bio');
// For edit listing and add listing forms
$fieldsCollection->addField('pname');
$fieldsCollection->addField('pprice');
$fieldsCollection->addField('pdescription');

// Setting up image save paths
$imagesDir = 'images/';

switch ($action) {
  case 'view_account' :
    $pageTitle = "View Account";
    
    include 'account/view_account.php';
    break;
  
  case 'edit_account_form' :
    $pageTitle = "Edit Account";
    // Get the values of our user from sessions.util
    $fName = getUserFirstName();
    $lName = getUserLastName();
    $workPhone = getUserWorkPhone();
    if ($workPhone == "Not yet set.") {
      $workPhone = "";
    }
    $persPhone = getUserPersonalPhone();
    if ($persPhone == "Not yet set.") {
      $persPhone = "";
    }
    $bio = getUserBio();
    if ($bio == "Not yet set.") {
      $bio = "";
    }
    $pwError = "";
    
    include 'account/edit_account_form.php';
    break;
  
  case 'edit_account' :
    $pageTitle = "Account Edit Error";
    // Get user ID
    $userID = getUserID();
    // Get the post variables
    $fName = filter_input(INPUT_POST, 'first_name');
    $lName = filter_input(INPUT_POST, 'last_name');
    $email = getUserEmail();
    $bio = strip_tags(filter_input(INPUT_POST, 'bio'), "<h1><h2><h3><h4><h5><h6><p><ul><ol><li><strong><i><em><b><u>");
    $validator->text('first_name', $fName);
    $validator->text('last_name', $lName);
    // Provide varification for phone number
    $workPhone = filter_input(INPUT_POST, 'w_phone');
    if (isset($workPhone)) {
      $validator->phone('w_phone', $workPhone);
    } else {
      $workPhone = "";
    }
    $persPhone = filter_input(INPUT_POST, 'p_phone');
    if (isset($persPhone)) {
      $validator->phone('p_phone', $persPhone);
    } else {
      $persPhone = "";
    }
    // Biography validation
    if (isset($bio)) {
      $validator->text('bio', $bio, false, 1, 2048);
    } else {
      $bio = "";
    }
    // Check to see if the user wanted to change their password based on if there old password was entered
    $password = "";
    $oldPassword = filter_input(INPUT_POST, 'old_pw');
    if (! empty($oldPassword)) {
      if (isValidUserLogin($email, $oldPassword)) {
        $pw1 = filter_input(INPUT_POST, 'new_pw1');
        $pw2 = filter_input(INPUT_POST, 'new_pw2');
        if (strcmp($pw1, $pw2) != 0) {
          $pwError = "Passwords do not match!";
          include 'account/edit_account_form.php';
          break;
        } else {
          $password = $pw1;
          $validator->password('new_pw1', $password);
        }
      } else {
        $pwError = "Incorrect Old Password! Please try again.";
        include 'account/edit_account_form.php';
        break;
      }
    }
    // Does the form have errors?
    if ($fieldsCollection->hasErrors()) {
      $pwError = "";
      include 'account/edit_account_form.php';
      break;
    }
    // Processing the users image
    $imageFileName = getUserPhoto();
    if ($_FILES ['photo'] ['error'] == 0) {
      $source = $_FILES ['photo'] ['tmp_name'];
      $imageFileName = "users" . $userID . ".png";
      $userImageSavePath = $docRoot . $appPath . $imagesDir . 'users/';
      $target = $docRoot . $appPath . $imagesDir . 'users/' . $imageFileName;
      move_uploaded_file($source, $target);
      process_image($userImageSavePath, $imageFileName);
    }
    // Update the user
    updateUser($userID, $fName, $lName, $email, $password, $imageFileName, $workPhone, $persPhone, $bio);
    $_SESSION ['user'] = getUserByEmail($email);
    
    redirect('.');
    break;
  
  case 'delete_account' :
    $pageTitle = "Account Delete Error";
    // Get user and delete them
    $userID = filter_input(INPUT_POST, 'user_id');
    deleteUser($userID);
    // Get users associated image and delete
    if (! empty(getUserPhoto())) {
      $userImageSavePath = $docRoot . $appPath . $imagesDir . 'users/';
      $userImage = getUserPhoto();
      delete_image($userImageSavePath, $userImage);
    }
    // unset and destroy session
    session_unset('user');
    session_destroy();
    
    redirect('..');
    break;
  
  case 'view_listings' :
    $pageTitle = "View Your Listings";
    $userID = getUserID();
    $products = getProductsByUser($userID);
    $productImageSavePath = $docRoot . $appPath . $imagesDir . 'products/';
    
    include 'account/view_listings.php';
    break;
  
  case 'view_listing' :
    $pageTitle = "Viewing Listing";
    $productID = filter_input(INPUT_GET, 'pi');
    $userID = getUserID();
    if (isUsersProduct($productID, $userID)) {
      $product = getProduct($productID);
      $name = $product ['product_name'];
      $category = $product ['category_name'];
      $descr = $product ['product_descr'];
      $price = $product ['product_price'];
      $negotiate = $product ['negotiate_fg'];
      $photo = $product ['product_photo'];
    } else {
      display_error("You cannot attampt to make changes to a listing that is not yours.");
      break;
    }
    include 'account/view_listing.php';
    break;
  
  case 'edit_listing_form' :
    $pageTitle = "Editing Listing";
    $catError = "";
    $productID = filter_input(INPUT_GET, 'pi');
    $userID = getUserID();
    if (isUsersProduct($productID, $userID)) {
      $panelTitle = "Edit Listing";
      $product = getProduct($productID);
      $pid = $product ['product_id'];
      $name = $product ['product_name'];
      $currentCategoryID = $product ['category_id'];
      $currentCategory = $product ['category_name'];
      $categories = getCategories();
      $descr = $product ['product_descr'];
      $price = $product ['product_price'];
      $negotiate = $product ['negotiate_fg'];
      $photo = $product ['product_photo'];
      $doAction = "edit_listing";
    } else {
      display_error("You cannot attampt to make changes to a listing that is not yours.");
      break;
    }
    include 'account/edit_listing_form.php';
    break;
  
  case 'edit_listing' :
    $pageTitle = "Listing Edit Error";
    $panelTitle = "Edit Listing";
    $catError = "";
    $pid = filter_input(INPUT_POST, 'pid');
    $product = getProduct($pid);
    $userID = getUserID();
    $doAction = "edit_listing";
    // Is it the user's product
    if (isUsersProduct($pid, $userID)) {
      $panelTitle = "Edit Listing";
      $name = filter_input(INPUT_POST, 'product_name');
      $currentCategoryID = $product ['category_id'];
      $currentCategory = $product ['category_name'];
      $categories = getCategories();
      $descr = strip_tags(filter_input(INPUT_POST, 'description'), "<h1><h2><h3><h4><h5><h6><p><ul><ol><li><strong><i><em><b><u>");
      $price = filter_input(INPUT_POST, 'product_price');
      $negotiate = filter_input(INPUT_POST, 'product_negotiable');
      $category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
      if ($category == false || $category == null) {
        $catError = "Must choose a category";
        include 'account/edit_listing_form.php';
        break;
      }
      $validator->text('pname', $name);
      $validator->money('pprice', $price);
      $validator->text('pdescription', $descr, true, 1, 2048);
      if ($fieldsCollection->hasErrors()) {
        include 'account/edit_listing_form.php';
        break;
      }
      try {
        $pid = updateProduct($pid, $name, $category, $descr, $price, $negotiate);
      } catch (PDOException $e) {
        display_error($e->getMessage());
      }
      $imageFileName = "";
      if ($_FILES ['photo'] ['error'] == 0) {
        $source = $_FILES ['photo'] ['tmp_name'];
        $imageFileName = "product" . $userID . $pid . ".png";
        $productImageSavePath = $docRoot . $appPath . $imagesDir . 'products/';
        $target = $docRoot . $appPath . $imagesDir . 'products/' . $imageFileName;
        move_uploaded_file($source, $target);
        process_image($productImageSavePath, $imageFileName);
        addProductImage($productID, $imageFileName);
      }
    } else {
      display_error("Here edit You cannot attampt to make changes to a listing that is not yours.");
      break;
    }
    redirect(".?action=view_listings");
    break;
  
  case 'add_listing_form' :
    $pageTitle = "Adding Listing";
    $panelTitle = "Add Listing";
    $userID = getUserID();
    $pid = "";
    $name = "";
    $currentCategoryID = "";
    $catError = "";
    $currentCategory = "";
    $categories = getCategories();
    $descr = "";
    $price = "";
    $negotiate = "";
    $photo = "";
    $doAction = "add_listing";
    
    include 'account/edit_listing_form.php';
    break;
  
  case 'add_listing' :
    $pageTitle = "Adding Listing Error";
    $panelTitle = "Add Listing";
    $catError = "";
    $pid = "0";
    $userID = getUserID();
    $doAction = "add_listing";
    $name = filter_input(INPUT_POST, 'product_name');
    $currentCategoryID = "";
    $currentCategory = "";
    $categories = getCategories();
    $descr = strip_tags(filter_input(INPUT_POST, 'description'), "<h1><h2><h3><h4><h5><h6><p><ul><ol><li><strong><i><em><b><u>");
    $price = filter_input(INPUT_POST, 'product_price');
    $negotiate = filter_input(INPUT_POST, 'product_negotiable');
    $category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
    if ($category == false || $category == null) {
      $catError = "Must choose a category";
      include 'account/edit_listing_form.php';
      break;
    }
    $validator->text('pname', $name);
    $validator->money('pprice', $price);
    $validator->text('pdescription', $descr, true, 1, 2048);
    if ($fieldsCollection->hasErrors()) {
      include 'account/edit_listing_form.php';
      break;
    }
    try {
      $pid = createProduct($userID, $name, $category, $descr, $price, $negotiate);
    } catch (PDOException $e) {
      display_error($e->getMessage());
    }
    $imageFileName = "";
    if ($_FILES ['photo'] ['error'] == 0) {
      $source = $_FILES ['photo'] ['tmp_name'];
      $imageFileName = "product" . $userID . $pid . ".png";
      $productImageSavePath = $docRoot . $appPath . $imagesDir . 'products/';
      $target = $docRoot . $appPath . $imagesDir . 'products/' . $imageFileName;
      move_uploaded_file($source, $target);
      process_image($productImageSavePath, $imageFileName);
      addProductImage($pid, $imageFileName);
    }
    redirect(".?action=view_listings");
    break;
  
  case 'delete_listing' :
    $userID = getUserID();
    $productID = filter_input(INPUT_POST, 'pid');
    deleteProduct($productID);
    $productImageSavePath = $docRoot . $appPath . $imagesDir . 'products/';
    $imageFileName = "product" . $userID . $productID . ".png";
    delete_image($productImageSavePath, $imageFileName);
    redirect('.?action=view_listings');
    break;
  
  default :
    // Send them right on back
    redirect('.');
    break;
}
<?php
// Required Files
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
    $action = 'listings';
  }
}
// Page Title Reset
$pageTitle = "";
// Directing the user's interaction
switch ($action) {
  case "listings" :
    $category = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT);
    $products = "";
    $cName = "";
    $categories = getCategories();
    if ($category == null || $category == false || ! isset($category)) {
      $products = getAllProducts();
    } else {
      $products = getAllProducts($category);
      $cInfo = getCategory($category);
      $cName = $cInfo ['category_name'];
    }
    include 'marketplace/view_listings.php';
    break;
  
  case "listing" :
    $productID = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT);
    if ($productID == null || $productID == false || ! isset($productID)) {
      redirect(".");
      break;
    } else {
      $product = getProduct($productID);
      include 'marketplace/view_listing.php';
    }
    break;
  
  case "user" :
    $userID = filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT);
    if ($userID == null || $userID == false || ! isset($userID)) {
      redirect(".");
      break;
    }
    $user = getUser($userID);
    $products = getProductsByUser($userID);
    include 'marketplace/view_user.php';
    break;
  
  case 'email_listing' :
    $pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT);
    if ($pid == false || $pid == null || empty($pid)) {
      redirect(".");
      break;
    }
    $message = strip_tags(filter_input(INPUT_POST, 'email_body'), "<h1><h2><h3><h4><h5><h6><p><ul><ol><li><strong><i><em><b><u>");
    $product = getProduct($pid);
    $owner = $product['user_first_name'] . " " . $product['user_last_name'];
    $ownerEmail = $product['user_email'];
    $pName = $product['product_name'];
    $to = $owner . '<' . $ownerEmail . '>';
    $from = "Marketplace Admin <pdean@westga.edu>";
    $subject = "[UWG MARKETPLACE] Inquiry About Your Product";
    $body = createListingEmail($pName, $owner, $message);
    $isHTML = true;
    // Sending the email
    send_email($to, $from, $subject, $body, $isHTML);
    redirect(".?action=view_listing&pid=".$pid);
    break;
    
  default :
    // Send them right on back
    redirect('.');
    break;
}
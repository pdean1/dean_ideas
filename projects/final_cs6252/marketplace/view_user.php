<?php
// This if block performs a redirect if a user accessed this page in an undesired way.
if (! isset($_SESSION ['user'])) {
  header('Location: ../');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'view/head.php';?>
  </head>
<body>
    <?php include 'view/main_navigation.php';?>
    <div class="container">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3>View Listings</h3>
      </div>
      <div class="panel-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>
                <div class="col-xs-12 col-sm-4">
                  <h3>
                    Listings by: <?php echo $user['user_first_name'] . " " . $user['user_last_name']; ?>
                  </h3>
                  <div class="img-thumbnail">
                    <?php if (!empty($user['user_photo'])) :?>
                    <img src="<?php echo '../images/users/' . $user['user_photo']; ?>" class="img-responsive">
                    <?php else :?>
                    <img src="<?php echo '../images/users/no_image.png'; ?>" class="img-responsive">
                    <?php endif;?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <h3>Contact Info.</h3>
                  <p>Work Phone:<br>
                     <?php echo $user['user_work_phone']?><br>
                     Personal Phone:<br>
                     <?php echo $user['user_personal_phone']?><br>
                     Email:<br>
                     <?php echo $user['user_email']?>
                  </p>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <h3>
                    Bio:
                  </h3>
                  <?php echo $user['user_bio'];?>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) : ?>
            <tr>
              <td>
                <div class="col-xs-12 col-sm-5">
                  <div class="img-thumbnail">
                    <h4 class="text-center">
                      <a href=".?action=listing&pid=<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></a>
                    </h4>
                    <?php if (!empty($product['product_photo'])) :?>
                    <img src="<?php echo '../images/products/' . $product['product_photo']; ?>" class="img-responsive">
                    <?php else :?>
                    <img src="<?php echo '../images/products/no-image.png'; ?>" class="img-responsive">
                    <?php endif;?>
                    <?php if ($product['negotiate_fg'] == 'Y') :?>
                    <p class="text-right">
                      <strong>$<?php echo $product['product_price']; ?> <span class="label label-success">Price is
                          Negotiable</span></strong>
                    </p>
                    <?php else :?>
                    <p class="text-right">
                      <strong>$<?php echo $product['product_price']; ?> <span class="label label-warning">Price is
                          Non-Negotiable</span></strong>
                    </p>
                    <?php endif;?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-7">
                  <h4>
                    <span class="label label-info">Category: <?php echo $product['category_name']; ?></span>
                  </h4>
                  <p>
                    <strong>Description</strong>
                  </p>
                  <?php echo $product['product_descr']; ?>
                  <p>
                    <strong>Created:</strong> <br><?php echo $product['created_timestamp']; ?></p>
                  <p>
                    <strong>Updated:</strong> <br><?php echo $product['updated_timestamp']; ?></p>
                  <p>
                    <strong>Sold By:</strong> 
                    <a href="action=user&uid=<?php echo $product['user_id']; ?>">
                      <?php echo $product['user_first_name'] . " " . $product['user_last_name']; ?> | <?php echo $product['user_email']?>
                    </a>
                  </p>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
      <?php include 'view/footer.php';?>
    </div>
  <!-- /container -->
</body>
</html>
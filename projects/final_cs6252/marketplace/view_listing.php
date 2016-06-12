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
        <h2>View Listing</h2>
      </div>
      <div class="panel-body">
        <div class="col-xs-12 col-sm-5">
          <a href="."><span class="glyphicon glyphicon-arrow-left"></span> Go Back</a>
          <div class="img-thumbnail">
            <h3 class="text-center"><?php echo $product['product_name']; ?></h3>
            <?php if (!empty($product['product_photo'])) :?>
            <img src="<?php echo '../images/products/' . $product['product_photo']; ?>" class="img-responsive">
            <?php else :?>
            <img src="<?php echo '../images/products/no-image.png'; ?>" class="img-responsive">
            <?php endif;?>
            <?php if ($product['negotiate_fg'] == 'Y') :?>
            <p class="text-right">
              <strong>$<?php echo $product['product_price']; ?> <span class="label label-success">Price is Negotiable</span></strong>
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
            <strong>Sold By:</strong> <a href=".?action=user&uid=<?php echo $product['user_id']; ?>"><?php echo $product['user_first_name'] . " " . $product['user_last_name']; ?> | <?php echo $product['user_email']?></a>
          </p>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal">
            <span class="glyphicon glyphicon-envelope"></span> Email <?php echo $product['user_first_name'] . " " . $product['user_last_name']; ?></button>
        </div>
      </div>
    </div>
      <?php include 'view/footer.php';?>
    </div>
  <!-- /container -->
  <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="email" action="." method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Send an email to <?php echo $product['user_first_name'] . " " . $product['user_last_name']; ?></h4>
          </div>
          <div class="modal-body">
            <p>
              <strong>Email Message:</strong>
            </p>
            <textarea class="mce" name="email_body" cols="6"></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          <input type="hidden" name="pid" value="<?php echo $product['product_id'];?>">
          <input type="hidden" name="action" value="email_listing">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
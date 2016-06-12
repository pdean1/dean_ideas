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
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>View Your Listing</strong></div>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="panel panel-info">
              <div class="panel-heading">Actions</div>
              <div class="panel-body">
                <ul class="list-group text-center">
                  <li class="list-group-item"><a class="btn btn-info"
                    href=".?action=edit_listing_form&pi=<?php echo $product['product_id']?>"> <span
                      class="glyphicon glyphicon-pencil"></span> Edit
                  </a></li>
                  <li class="list-group-item"><form action="." method="post" name="delete_posting">
                      <input type="hidden" name="action" value="delete_listing"> <input type="hidden" name="pid"
                        value="<?php echo $product['product_id']?>">
                      <button class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                      </button>
                    </form></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-9 col-md-9">
            <div class="row">
              <div class="col-sm-12 col-md-3">
                <div class="img-thumbnail">
                <?php if (!empty($product['product_photo'])) :?>
                  <img src="<?php echo '../images/products/' . $photo; ?>" class="img-responsive">
                <?php else :?>
                  <img src="<?php echo '../images/products/no-image.png'; ?>" class="img-responsive">
                <?php endif;?>
                </div>
              </div>
              <div class="col-sm-12 col-md-9">
                <h3>
                  Item Name: <br> <small><?php echo $name ?></small>
                </h3>
                <h3>
                  Category: <br> <small><?php echo $category ?></small>
                </h3>
                <h3>
                  Description: <br> <small><?php echo $descr ?></small>
                </h3>
                <h3>
                  Price: <br> <small>$<?php echo $price; ?></small>
                </h3>
                <h4>
                  Negotiable: <br> <small>
                  <?php if ($product['negotiate_fg'] == 'Y') :?>
                  <span class="label label-success">Price is Negotiable</span>
                  <?php else :?>
                  <span class="label label-warning">Price is Non-Negotiable</span>
                  <?php endif;?> 
                  </small>
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <?php include 'view/footer.php';?>
    </div>
  <!-- /container -->
</body>
</html>
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
      <div class="panel-heading">
        <strong>Your Listings</strong>
      </div>
      <div class="panel-body">
        <a href=".?action=add_listing_form" class="btn btn-success"> <span class="glyphicon glyphicon-plus"></span> Add
          a Listing
        </a>
        <table class="table table-hover table-condensed">
          <thead>
            <tr>
              <th class="col-xs-1">Edit</th>
              <th class="col-xs-5 col-sm-3">Product Info.</th>
              <th class="col-xs-5 col-sm-7">Details</th>
              <th class="col-xs-1">Delete</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($products as $product) :?>
            <tr>
              <td class="text-center"><a class="btn btn-info"
                href=".?action=edit_listing_form&pi=<?php echo $product['product_id']?>"> <span
                  class="glyphicon glyphicon-pencil"></span> Edit
              </a></td>
              <td>
                <h4>
                  <a href=".?action=view_listing&pi=<?php echo $product['product_id']?>"><?php echo $product['product_name'];?></a>
                </h4>
                <div class="img-thumbnail">
                <?php if (!empty($product['product_photo'])) :?>
                  <img src="<?php echo '../images/products/' . $product['product_photo']; ?>" class="img-responsive">
                <?php else :?>
                  <img src="<?php echo '../images/products/no-image.png'; ?>" class="img-responsive">
                <?php endif;?>
                </div>
                <p></p>
              </td>
              <td>
                <p>
                  <strong>Category:</strong> <?php echo $product['category_name']?></p>
                <p>
                  <strong>Description:</strong><br><?php echo $product['product_descr']?></p>
                <p>
                  <strong>Price:</strong> $<?php echo $product['product_price']?><br>
                  <?php if ($product['negotiate_fg'] == 'Y') :?>
                  <span class="label label-success">Price is Negotiable</span>
                  <?php else :?>
                  <span class="label label-warning">Price is Non-Negotiable</span>
                  <?php endif;?> 
                </p>
              </td>
              <td>
                <form action="." method="post" name="delete_posting">
                  <input type="hidden" name="action" value="delete_listing"> <input type="hidden" name="pid"
                    value="<?php echo $product['product_id']?>">
                  <button class="btn btn-danger">
                    <span class="glyphicon glyphicon-minus"></span> Delete
                  </button>
                </form>
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
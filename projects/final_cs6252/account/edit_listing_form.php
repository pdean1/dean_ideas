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
<body onload="setCB()">
    <?php include 'view/main_navigation.php';?>
    <div class="container">
    <form name="edit_account" action="." method="post" enctype="multipart/form-data">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <strong>View Your Listing</strong>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
              <div class="panel panel-info">
                <div class="panel-heading">Add a Photo?</div>
                <div class="panel-body">
                  <?php if (!empty($product['product_photo'])) :?>
                  <img src="<?php echo '../images/products/' . $product['product_photo']; ?>" class="img-responsive">
                  <?php else :?>
                  <img src="<?php echo '../images/products/no-image.png'; ?>" class="img-responsive">
                  <?php endif;?>
                </div>
                <div class="panel-footer">
                  <input name="photo" type="file" class="form-control">
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-8">
              <div class="panel panel-info">
                <div class="panel-heading">Listing Info</div>
                <div class="panel-body">
                  <h3>Item Name:</h3>
                  <input name="product_name" type="text" class="form-control" value="<?php echo $name;?>" required>
                  <p class="text-danger"><?php echo $fieldsCollection->getField('pname')->getHTML();?></p>
                  <h3>Category:</h3>
                  <select name="category" class="form-control" required>
                    <option value="<?php echo $currentCategoryID; ?>"><?php echo $currentCategory; ?></option>
                  <?php foreach ($categories as $category) :?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                  <?php endforeach;?>
                  </select>
                  <p class="text-danger"><?php echo $catError; ?></p>
                  <h3>Price:</h3>
                  <div class="input-group">
                    <span class="input-group-addon">$</span> <input name="product_price" type="text"
                      class="form-control" value="<?php echo $price; ?>">
                  </div>
                  <p class="text-danger"><?php echo $fieldsCollection->getField('pprice')->getHTML();?></p>
                  <span>Is price negotiable?</span> <label class="checkbox-inline"><input name="product_negotiable"
                    value="Y" class="radio input-lg" type="radio"><span class="label label-success">Yes</span></label> <label
                    class="checkbox-inline"><input name="product_negotiable" value="N" class="radio input-lg"
                    type="radio"><span class="label label-warning">No</span></label>
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <h4>Description:</h4>
              <textarea name="description" class="mce" rows="6" cols=""><?php echo $descr; ?></textarea>
              <p class="text-danger"><?php echo $fieldsCollection->getField('pdescription')->getHTML();?></p>
            </div>
          </div>
        </div>
        <div class="panel-footer text-right">
          <input type="hidden" name="pid" value="<?php echo $pid; ?>"> <input type="hidden" name="action"
            value="<?php echo $doAction; ?>">
          <button type="submit" class="btn btn-success">
            <span class="glyphicon glyphicon-thumbs-up"></span> Submit
          </button>
          <a href=".?action=view_listings" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down"></span>
            Cancel</a>
        </div>
      </div>
    </form>
      <?php include 'view/footer.php';?>
    </div>
  <!-- /container -->
  <script type="text/javascript">
  function setCB() {
    var negFG = "<?php echo $negotiate?>";
    var radios = document.getElementsByName('product_negotiable');
    if (negFG === "Y") {
      radios[0].checked = true;
    } else {
      radios[1].checked = true;
    }
  }
  </script>
</body>
</html>
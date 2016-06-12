<?php $pageTitle = "ERROR"?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include 'view/head.php';?>
  </head>
<!---------------------------------------------------------------------------------------------------------->
  <body>
    <?php include 'view/main_navigation.php';?>
    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>
          <span class="uwg-heading"><span class="dark-blue">UWG</span>
          <span class="light-blue">Marketplace</span></span>
        </h1>
        <h2>Whoa! There where errors present in the last request!</h2>
        <p><?php echo $errorMessage;?></p>
      </div>
      <?php include 'view/footer.php';?>
    </div> <!-- /container -->
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'view/head.php';?>
  </head>
<body>
    <?php include 'view/main_navigation.php';?>
    <div class="container">
    <div class="jumbotron">
      <h1>
        <span class="uwg-heading"><span class="dark-blue">UWG</span> <span class="light-blue">Marketplace</span></span>
      </h1>
      <div class="row home-row">
        <div class="col-sm-3 home-btns text-center" onclick="changeLocation('marketplace');">
          <h1>
            <span class="glyphicon glyphicon-shopping-cart"></span>
          </h1>
          <h2>
            <span class="uwg-heading"><span class="dark-blue">View</span> <span class="light-blue">Marketplace</span></span>
          </h2>
        </div>
        <div class="col-sm-3 home-btns text-center" onclick="changeLocation('account/?action=view_listings');">
          <h1>
            <span class="glyphicon glyphicon-list"></span>
          </h1>
          <h2>
            <span class="uwg-heading"><span class="dark-blue">my</span><span class="light-blue">Listings</span></span>
          </h2>
        </div>
        <div class="col-sm-3 home-btns text-center" onclick="changeLocation('account');">
          <h1>
            <span class="glyphicon glyphicon-user"></span>
          </h1>
          <h2>
            <span class="uwg-heading"><span class="dark-blue">my</span><span class="light-blue">Info</span></span>
          </h2>
        </div>
        <div class="col-sm-3 home-btns text-center" onclick="changeLocation('authorization/?action=logout');">
          <h1>
            <span class="glyphicon glyphicon-log-out"></span>
          </h1>
          <h2>
            <span class="uwg-heading"><span class="dark-blue">Log</span><span class="light-blue">Out</span></span>
          </h2>
        </div>
      </div>
    </div>
      <?php include 'view/footer.php';?>
    </div>
    <script type="text/javascript">
    function changeLocation(location) {
        window.location.href = location;
    }
    </script>
  <!-- /container -->
</body>
</html>
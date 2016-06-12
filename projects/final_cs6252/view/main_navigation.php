    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" 
                  aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $appPath; ?>">
            <span class="uwg-heading"><span class="dark-blue">UWG</span>
            <span class="light-blue">Marketplace</span></span>            
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo $appPath; ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li>
              <a href="<?php echo $appPath . "marketplace"?>"><span class="glyphicon glyphicon-shopping-cart"></span> View Marketplace</a>
            </li>
            <li>
              <a href="<?php echo $appPath . "account/.?action=view_listings"?>"><span class="glyphicon glyphicon-th-list"></span> myListings</a>
            </li>
            <li>
              <a href="<?php echo $appPath . "account/.?action=view_account"?>"><span class="glyphicon glyphicon-user"></span> myProfile</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo $appPath . "authorization/.?action=logout";?>"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
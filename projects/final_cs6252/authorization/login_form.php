<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include 'view/head.php';?>
  </head>
  <body>
    <div class="container">
      <form class="form-signin" name="sign-in" method="post" action=".">
        <h1 class="form-signin-heading">
          <span class="uwg-heading"><span class="dark-blue">UWG</span>
          <span class="light-blue">Marketplace</span></span>
        </h1>
        <fieldset>
          <legend>Sign In</legend>
          <label for="email">UWG Email Address</label>
          <input type="email" id="email" name="user_email" class="form-control" placeholder="UWG Email" 
                 required onkeyup="checkEmail(this)" data-toggle="tooltip" data-placement="top" 
                 data-trigger="focus" title="Must be a valid UWG email. westga.edu or my.westga.edu" 
                 value="<?php echo htmlspecialchars($email)?>">
          <p class="text-danger"><?php echo $fieldsCollection->getField('user_email')->getHTML();?></p>
          <label style="" for="password">Password:</label>
          <input type="password" id="password" name="user_password" class="form-control" 
                 placeholder="Password" required data-toggle="tooltip" data-placement="top" data-trigger="focus" 
                 title="Must be at least 6 characters and contain upper and lowecase letters, a number, and a special character.">
          <p class="text-danger"><?php echo $fieldsCollection->getField('user_password')->getHTML();?></p>
          <p class="text-danger"><?php echo $loginError?></p>
          <div style="text-align:right">
            <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
          </div>
        </fieldset>
        <input type="hidden" name="action" value="login">
      </form>
      <div style="text-align:center;">
        <p>Don't have a Account?</p>
        <a href=".?action=view_register" class="btn btn-default">Create One</a>
      </div>
    </div>
    <address style="text-align: center;">&copy; Patrick Dean <?php echo date('Y');?>. <?php print_r($_SESSION)?></address>
    <!-- /container -->
    <script src="<?php echo $appPath; ?>/js/validation.js"></script>
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
    </script>
  </body>
</html>
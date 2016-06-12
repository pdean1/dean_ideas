<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include 'view/head.php';?>
  </head>
  <body>
    <div class="container">
      <form class="form-signin" name="register" method="post" action=".">
        <h1 class="form-signin-heading">
          <span class="uwg-heading"><span class="dark-blue">UWG</span>
          <span class="light-blue">Marketplace</span></span>
        </h1>
        <h3>Register an Account</h3>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" required>
        <p class="text-danger"><?php echo $fieldsCollection->getField('first_name')->getHTML();?></p>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" required>
        <p class="text-danger"><?php echo $fieldsCollection->getField('last_name')->getHTML();?></p>
        <label for="email">Email (must be a westga.edu email!)</label>
        <input type="email" name="user_email" id="email" class="form-control" required onkeyup="checkEmail(this)"
               data-toggle="tooltip" data-placement="top" data-trigger="focus"
               title="Must be a valid UWG email. westga.edu or my.westga.edu" 
               value="<?php echo htmlspecialchars($email)?>">
        <p class="text-danger"><?php echo $fieldsCollection->getField('user_email')->getHTML();?></p>
        <label for="password">Password</label>
        <input type="password" name="password1" id="password1" class="form-control" required 
               data-toggle="tooltip" data-placement="top" data-trigger="focus" 
               title="Must be at least 6 characters long and contain upper and lowercase letters, a digit, and a special character">
        <p class="text-danger"><?php echo $fieldsCollection->getField('password1')->getHTML();?></p>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="password2" id="password2" class="form-control" required
               data-toggle="tooltip" data-placement="top" data-trigger="focus" title="Must match previous input!">
        <p class="text-danger"><?php echo $registerError; ?></p>
        <div style="text-align:right">
          <button class="btn btn-lg btn-primary" type="submit">Register</button>
        </div>
        <input type="hidden" name="action" value="register">
      </form>
      <div style="text-align:center;">
        <p>Already have an account?</p>
        <a href=".?action=view_login" class="btn btn-default">Sign In</a>
      </div>
      <address style="text-align:center">&copy; Patrick Dean <?php echo date('Y');?>. <?php print_r($_SESSION)?></address>
    </div> 
    <!-- /container -->
    <script src="<?php echo $appPath; ?>/js/validation.js"></script>
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
    </script>
  </body>
</html>
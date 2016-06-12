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
        <h1 class="panel-title">
          <strong>Edit Your Account</strong>
        </h1>
      </div>
      <form name="edit_account" action="." method="post" enctype="multipart/form-data">
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-offset-0 col-xs-12 col-sm-6 col-sm-offset-0 col-md-4 col-md-offset-0">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <span class="panel-title">Change Photo</span>
                </div>
                <div class="panel-body">
                  <div class="thumbnail">
                    <img alt="<?php echo getUserFullName();?>'s Picture" src="<?php echo getUserPhotoLink();?>">
                    <p class="text-center">
                      <strong><?php echo getUserFullName();?></strong>
                    </p>
                  </div>
                  <label>Add A Photo?</label> <input type="file" class="form-control" name="photo">
                </div>
              </div>
            </div>
            <div class="col-xs-offset-0 col-xs-12 col-sm-6 col-sm-offset-0 col-md-4 col-md-offset-0">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <span class="panel-title">Personal Info</span>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                      <label>First Name:</label> <input id="firstName" name="first_name" class="form-control"
                        type="text" value="<?php echo $fName; ?>">
                      <p class="text-danger"><?php echo $fieldsCollection->getField('first_name')->getHTML();?></p>
                    </div>
                    <div class="col-xs-10 col-xs-offset-1">
                      <label>Last Name:</label> <input id="lastName" name="last_name" class="form-control" type="text"
                        value="<?php echo $lName; ?>">
                      <p class="text-danger"><?php echo $fieldsCollection->getField('last_name')->getHTML();?></p>
                    </div>
                    <div class="col-xs-10 col-xs-offset-1">
                      <label>Email:</label> <input id="userEmail" name="user_email" class="form-control" type="text"
                        disabled value="<?php echo getUserEmail(); ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-0 col-md-4 col-md-offset-0">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <span class="panel-title">Change Phone Numbers</span>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-0">
                      <label>Work Phone:</label> <input id="workPhone" name="w_phone" class="form-control" type="text"
                        maxlength="12" placeholder="111-222-3333" value="<?php echo $workPhone; ?>">
                      <p class="text-danger"><?php echo $fieldsCollection->getField('w_phone')->getHTML();?></p>
                    </div>
                    <div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-0">
                      <label>Personal Phone:</label> <input id="personalPhone" name="p_phone" class="form-control"
                        type="text" maxlength="12" placeholder="111-222-3333" value="<?php echo $persPhone; ?>">
                      <p class="text-danger"><?php echo $fieldsCollection->getField('p_phone')->getHTML();?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <span class="panel-title">Change Password?</span>
                </div>
                <div class="panel-body">
                  <p>You can leave the fields blank to leave password as is.</p>
                  <label>Old Password</label> <input name="old_pw" class="form-control" type="password"> <label>New
                    Password</label> <input name="new_pw1" class="form-control" type="password">
                  <p class="text-danger"><?php echo $fieldsCollection->getField('new_pw1')->getHTML();?></p>
                  <label>Enter Password Again</label> <input name="new_pw2" class="form-control" type="password">
                  <p class="text-danger"><?php echo $fieldsCollection->getField('new_pw2')->getHTML();?></p>
                  <p class="text-danger"><?php echo $pwError; ?></p>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offest-1 col-md-12 col-md-offset-0">
              <label>Biography:</label>
              <textarea id="bioTextArea" name="bio" class="mce" rows="10"><?php echo $bio?></textarea>
            </div>
          </div>
        </div>
        <div class="panel-footer text-right">
          <input name="action" type="hidden" value="edit_account">
          <button type="submit" class="btn btn-success">
            <span class="glyphicon glyphicon-thumbs-up"></span> Submit
          </button>
          <a href="." class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down"></span> Cancel</a>
        </div>
      </form>
    </div>
      <?php include 'view/footer.php';?>
    </div>
  <!-- /container -->
</body>
</html>
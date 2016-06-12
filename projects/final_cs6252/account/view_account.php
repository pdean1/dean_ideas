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
          <strong><?php echo getUserFullName();?>'s Account View</strong>
        </h1>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-3 col-md-offset-0">
            <div class="panel panel-info text-center">
              <div class="panel-heading">
                <span>Account Actions</span>
              </div>
              <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item"><a href=".?action=edit_account_form" class="btn btn-primary"><span
                      class="glyphicon glyphicon-pencil"></span> Edit Account</a></li>
                  <li class="list-group-item"><a href=".?action=view_listings" class="btn btn-info"><span
                      class="glyphicon glyphicon-list-alt"></span> View Listings</a></li>
                  <li class="list-group-item">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                      <span class="glyphicon glyphicon-trash"></span> Delete Account
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xs-offset-1 col-xs-10 col-sm-6 col-sm-offset-3 col-md-3 col-md-offset-0">
            <div class="thumbnail">
              <img alt="<?php echo getUserFullName();?>'s Picture" src="<?php echo getUserPhotoLink();?>">
              <p class="text-center">
                <strong><?php echo getUserFullName();?></strong>
              </p>
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offest-2 col-md-6 col-md-offset-0">
            <h4>Email:</h4>
            <p><?php echo getUserEmail();?></p>
            <h4>Work Phone:</h4>
            <p><?php echo getUserWorkPhone();?></p>
            <h4>Personal Phone:</h4>
            <p><?php echo getUserPersonalPhone();?></p>
            <h4>Account Created On:</h4>
            <p><?php echo getUserDateCreated();?></p>
          </div>
          <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offest-2 col-md-9 col-md-offset-3">
            <h4>Biography:</h4>
            <p><?php echo getUserBio();?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title text-center" id="deleteLabel">Delete Account?</h3>
          </div>
          <div class="modal-body clearfix">
            <p class="text-center">Are you sure?</p>
          </div>
          <div class="modal-footer">
            <form name="delete_user" action="." method="post">
              <input type="hidden" name="action" value="delete_account"> <input type="hidden" name="user_id"
                value="<?php echo getUserID();?>">
              <button type="submit" class="btn btn-danger pull-left" data-toggle="tooltip" data-placement="top"
                data-trigger="hover" title="This process is irreversable and a new account will have to be created!.">DELETE</button>
            </form>
            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
      <?php include 'view/footer.php';?>
    </div>
  <!-- /container -->
</body>
</html>
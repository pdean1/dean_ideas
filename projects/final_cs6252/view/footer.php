      <div class="row">
        <p>User currently signed in:  
           <a href="<?php echo $appPath;?>account"><?php echo getUserFullName(); ?>
           <img class="img-circle" style="width:20px !important;" src="<?php echo getUserPhotoLink(); ?>">
           </a>
        <address>
          &copy; Patrick Dean <?php echo date('Y');?>.
        </address>
      </div>
      <script type="text/javascript">
        $(function() {$('[data-toggle="tooltip"]').tooltip()});
      </script>
<?php 
if ($pageTitle) {
	$pageTitle = " | $pageTitle";
} else {
	$pageTitle = "";
}
?>  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UWG Market Place<?php echo $pageTitle?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $appPath ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $appPath ?>css/sign-in.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $appPath ?>css/custom.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?php echo $appPath ?>js/bootstrap.min.js"></script>
    <script src="<?php echo $appPath ?>js/tiny_mce/tinymce.min.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      tinymce.init({
      selector: "textarea.mce",
      menubar : false,
      plugins: [
        "advlist lists charmap searchreplace contextmenu paste"
        ],
        toolbar: "undo | redo | styleselect | bullist | numlist"
      });
    </script>
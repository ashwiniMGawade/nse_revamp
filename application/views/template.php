<!DOCTYPE html>
<?PHP

if ( !isset( $_SESSION['user'] ) ) {
     // Redirect them to the login page
     header("Location:".$_SERVER['PHP_SELF']."?p=auth&a=login");
     exit;
}
?>
<html>
<head>
  <title>Log Archival Engine</title>
  <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="public/css/font.css"> 
  <link rel="stylesheet" href="public/css/bootstrap.min.css">  
  <link rel="stylesheet" href="public/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="public/css/bootstrap-multiselect.css"> 
  <link rel="stylesheet" href="public/css/w3.css">
  <link rel="stylesheet" href="public/css/font-awesome.min.css">
  <link rel="stylesheet" media="screen" href="public/css/style.css">
  <base href="/nse_revamp/">
  <style>
  /* Note: Try to remove the following lines to see the effect of CSS positioning */
  .affix {
    top: 0;
    width: 100%;
    z-index: 9999 !important;
  }

  .affix + .container-fluid {
    padding-top: 70px;
  }
  </style>
</head>
<body>

<?php if($isMain) { ?>
    <div class="container-fluid" id="particles-js" style="height:150px;width: 100%;"></div>
<?php } ?>

<?php include VIEW_PATH."header.php" ?>

<div class="container-fluid" style="height:auto">
  <div class="row">
        <div class="col-sm-2">
            <?php include VIEW_PATH."leftnav.php" ?>
        </div>
        <div class="col-sm-10">
            <?php include VIEW_PATH."breadcrumb.php" ?>
            <?php include $pageContent ?>
        </div>
    </div>
</div>
<?php include VIEW_PATH."footer.php" ?>




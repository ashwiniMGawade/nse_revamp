<!DOCTYPE html>
<html>
<head>
  <title>NSE automation Engine</title>
  <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="public/css/bootstrap.min.css">  
  <link rel="stylesheet" href="public/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" media="screen" href="public/css/style.css">
  <link rel="stylesheet" href="public/css/w3.css">
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

<div class="container-fluid" style="height:600px">
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




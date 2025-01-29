<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Musical Instruments</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">  
  <link rel="stylesheet" href="<?php echo $pathURL . 'assets/scss/custom.css'; ?>">
  <link rel="stylesheet" href="<?php echo $pathURL . 'assets/scripts/keen-slider/keen-slider.min.css' ?>">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</head>

<body class="bg-background">
  <?php include_once(__DIR__ . '/mockup/data-submenu.php'); ?>
  <?php include_once(__DIR__ . '/layout/header.php'); ?>
  <?php include_once(__DIR__ . '/layout/all-menu.php'); ?>
  <div class="bg-white">
    <?php include_once(__DIR__ . '/components/banners/home-banner.php'); ?>
    <?php include_once(__DIR__ . '/pages/homepage/home-page.php'); ?>
  </div>
  <?php include_once(__DIR__ . '/layout/footer.php'); ?>
  <script src="<?php echo $pathURL . '/assets/scripts/keen-slider/keen-slider.min.js' ?>"></script>
  <script src="<?php echo $pathURL . '/assets/scripts/keen-slider/keen-script.js' ?>"></script>
</body>

</html>
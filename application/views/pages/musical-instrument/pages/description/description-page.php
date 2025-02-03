<?php include_once(__DIR__ . '/../../mockup/description-data.php'); ?>
<div class="bg-white">
  <div class="border-bottom">
    <div class="container py-2">
      <nav aria-label="breadcrumb" class="m-0 p-0 fs-8">
        <ol class="breadcrumb m-0 p-0">
          <li class="breadcrumb-item"><a href="/musical-instrument/" class="text-primary text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="/musical-instrument/category/" class="text-primary text-decoration-none">Category</a></li>
          <li class="breadcrumb-item active" aria-current="page">Guitar</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="bg-white">
  <div class="container">
    <div class="row g-0">
      <div class="col-12 col-lg-6 col-xl-5">
        <?php include('description-gallery.php'); ?>
      </div>
      <div class="col-12 col-lg-6 col-xl-7">
        <div class="py-4">
          <?php include_once('description-content.php'); ?>
          <?php include_once('description-price.php'); ?>
          <?php include_once('description-order.php'); ?>
        </div>
      </div>
      <div class="col-12">
        <div class="py-4">
          <?php include_once('description-detail.php'); ?>
        </div>
      </div>
      <div class="col-12">
        <div class="py-4">
          <?php include_once('description-shipping.php'); ?>
        </div>
      </div>
      <div class="col-12">
        <div class="py-4">
          <?php include_once('description-related.php'); ?>
        </div>
      </div>
    </div>
  </div>
</div>

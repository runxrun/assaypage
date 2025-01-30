<div class="fs-4 text-dark">
  <?php echo $productDetail['prodName']; ?>
</div>
<div class="pt-2 fs-8 text-secondary">
  <?php echo $productDetail['prodNameLocale']; ?>
</div>
<div class="pt-3">
  <div class="border-top pt-3">
    <div class="row g-1">
      <div class="col-12 col-xl-6 d-flex">
        <div style="width: 160px;">
          <div class="fs-7 fw-bold text-dark">
            Brand
          </div>
        </div>
        <div style="width: calc(100% - 160px);">
          <div class="fs-7 text-secondary">
            <?php echo $productDetail['prodBrand']; ?>
          </div>
        </div>
      </div>
      <?php
      foreach ($productDetail['prodOptional'] as $key => $value) {
      ?>
        <div class="col-12 col-xl-6 d-flex">
          <div style="width: 160px;">
            <div class="fs-7 fw-bold text-dark">
              <?php echo $key; ?>
            </div>
          </div>
          <div style="width: calc(100% - 160px);">
            <div class="fs-7 text-secondary">
              <?php echo $value; ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php /*
<div class="container">
  <div class="row g-0">
    <div class="col-12 col-lg-6 col-xl-5">
      <div class="rn-sticky">
        <div class="py-4 pe-md-4">
          <?php include('description-gallery.php'); ?>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-7">
      <div class="py-4">
        
        
        
      </div>
    </div>
  </div>



  <div class="py-4">
    <div class="fs-7 text-secondary">
      <?php echo $productDetail['prodDescription']; ?>
    </div>
  </div>

</div>
*/ ?>
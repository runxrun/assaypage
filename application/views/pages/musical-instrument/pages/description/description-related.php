<div class="border-top pt-3">
  <div class="fs-5 fw-bold text-dark">
    Related Products
  </div>
  <div class="py-3">
    <div class="row g-3">
      <?php
      $array = [0, 1, 2, 3, 4, 5];
      foreach ($array as $item) {
      ?>
        <div class="col-6 col-md-3 col-lg-2">
          <div class="bg-white">
            <a
              href="/musical-instrument/product/"
              class="d-flex w-100"
              style="
                background-image: url('https://m.media-amazon.com/images/I/61uCatyZlXL._AC_SX679_.jpg');
                background-repeat: no-repeat;
                background-position: center;
                background-size: auto 100%;
              ">
              <img src="<?php echo $pathURL . 'assets/images/image-ratio-4-3.gif'; ?>" class="w-100">
            </a>
          </div>
          <div class="py-2">
            <a href="/musical-instrument/product/" class="d-block fs-7 text-decoration-none rn-result-link">
              Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
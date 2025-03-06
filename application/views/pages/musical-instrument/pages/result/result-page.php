<div class="bg-white border-bottom">
  <div class="container-fluid">
    <div class="p-2 fs-7 text-secondary">
      1-40 of over 100 results
    </div>
  </div>
</div>
<div class="bg-white">
  <div class="d-flex flex-wrap flex-lg-nowrap gap-0">
    <div style="min-width: 280px;">
       <?php include_once('result-filter.php'); ?>
    </div>
    <div class="w-100">
      <div class="p-4">
        <div class="row g-4">
          <?php for ($i = 0; $i < 40; $i++) { ?>
            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
              <div class="p-0">
                <div class="pb-2">
                  <a href="/musical-instrument/product/<?php echo $i; ?>" class="d-flex text-center w-100">
                    <img
                      src="https://m.media-amazon.com/images/I/61QtWR0r1PL._AC_SX679_.jpg"
                      style="width: 100%; height: 200px; object-fit: contain;">
                  </a>
                </div>
                <div class="pt-2 pb-2">
                  <a href="/musical-instrument/product/<?php echo $i; ?>" class="d-block fs-6 text-decoration-none fw-bold rn-result-link">
                    Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS
                  </a>
                </div>
                <div class="pt-0 pb-2 fs-7 text-primary">
                  Guitar
                </div>
                <div class="pt-0 pb-2">
                  <div class="d-flex align-items-center">
                    <div class="pe-3 fs-4 text-danger">฿70,972</div>
                    <div class="pe-0 fs-8 text-secondary text-decoration-line-through">List: ฿78,069</div>
                  </div>

                </div>
                <div class="pt-0 pb-4 fs-8 text-secondary">
                  Recusandae sapiente ab, incidunt neque reiciendis veritatis minima
                  consequatur quo fuga harum ab exercitationem?
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
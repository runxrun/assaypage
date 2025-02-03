<div class="bg-white border-bottom">
  <div class="container-fluid">
    <div class="p-2 fs-7 text-secondary">
      1-40 of over 100 results
    </div>
  </div>
</div>
<div class="bg-white">
  <div class="row g-0">
    <div class="col-12 col-md-3 col-lg-2">
      <div class="rn-sticky-">
        <div class="pt-4 px-4">
          <div class="">
            Filter
          </div>
        </div>
        <?php
        include(__DIR__ . '/../../mockup/data-filter.php');
        foreach ($dataFilter as $catg => $item) {
        ?>
          <div class="py-2 px-4">
            <div class="border-top pt-2 fs-7 fw-bold text-dark">
              <?php echo $catg; ?>
            </div>
            <div class="py-2">
              <?php foreach (array_slice($item, 0, 10) as $data) { ?>
                <div class="fs-7 text-secondary">
                  <?php echo $data; ?>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
    <div class="col-12 col-md-9 col-lg-10">
      <div class="p-4">
        <div class="row g-4">
          <?php for ($i = 0; $i < 40; $i++) { ?>
            <div class="col-6 col-lg-4 col-xl-3">
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
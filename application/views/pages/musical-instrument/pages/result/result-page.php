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
      <div class="rn-sticky">
        <div class="pt-4 px-4">
          Filter
        </div>
        <div class="p-4">
          <?php
          $categories = [
            'Guitars',
            'Pianos',
            'Drums',
            'Violins',
            'Flutes',
            'Saxophones',
            'Trumpets',
            'Clarinets'
          ];
          ?>
          <ul class="list-unstyled">
            <?php foreach ($categories as $category) { ?>
              <li class="mb-2">
                <a href="#" class="text-decoration-none text-secondary">
                  <?php echo $category; ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-9 col-lg-10">
      <div class="p-4">
        <div class="row g-4">
          <?php for ($i = 0; $i < 40; $i++) { ?>
            <div class="col-6 col-lg-4 col-xl-3">
              <div class="p-0">
                <div class="bg-light border">
                  <br><br><br><br>
                  <br><br><br><br>
                </div>
                <!-- 
                <div class="p-0 d-flex align-items-center justify-content-center">
                  <div class="p-3">
                    <img src="https://m.media-amazon.com/images/I/61aqMK4Op9L._AC_UL320_.jpg" class="img-fluid">
                  </div>
                </div>
                -->
                <div class="pt-2 pb-2 ">
                  <a href="/musical-instrument/product/<?php echo $i; ?>" class="d-block fs-6 text-decoration-none fw-bold rn-result-link">
                    Enya Nova Go Mini Acoustic Guitar Carbon Integral Molded 1/4 Size Mini Guitar Beginner Kit with Guitar Case (Black)
                  </a>
                </div>
                <div class="pt-0 pb-2 fs-7 text-primary">
                  Guitar
                </div>
                <div class="pt-0 pb-2">
                  <div class="d-flex align-items-center">
                    <div class="pe-3 fs-4 text-danger">฿11,984 </div>
                    <div class="pe-0 fs-8 text-secondary text-decoration-line-through">List: ฿14,980</div>
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
<div class="bg-header">
  <div class="p-0">
    <div class="container-fluid py-4">
      <div class="row justify-content-between g-3">
        <div class="col-auto">
          <button class="btn border-0 p-0 lh-1" onclick="window.location.href='/musical-instrument';">
            <div class="fs-4 fw-bold text-white">
              MUSICAL
            </div>
            <div class="fs-7 text-white opacity-50">
              INSTRUMENTS
            </div>
          </button>
        </div>
        <div class="col-8">
          <div class="d-flex gap-2">
            <div class="rn-autocomplete">
              <input 
                type="text" 
                name="search" 
                id="searchAutoComplete"
                class="form-control rounded-1 border-0 fs-7 py-2" 
                placeholder="Search..." 
                autocomplete="off">
            </div>
            <div class="p-0">
              <button
                type="button" 
                class="btn btn-warning border-0 fs-7 py-2 h-100" 
                onclick="window.location.href='/musical-instrument/category/<?php echo $categoryName; ?>';">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-auto">
          <div class="fs-6 fw-bold text-white">
            &nbsp;
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="p-0" style="background-color: rgba(255,255,255,0.1);">
    <div class="container-fluid ">
      <div class="d-flex flex-nowrap">
        <div class="p-0">
          <button
            class="btn border-0 p-2 text-nowrap w-100"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample">
            <div class="d-flex">
              <div class="pe-2 fs-8 text-white"><i class="fa-solid fa-bars"></i></div>
              <div class="pe-0 fs-8 text-white fw-bold">All</div>
            </div>
          </button>
        </div>
        <div class="flex-grow-1 overflow-hidden">
          <div class="w-100">
            <div id="keen-slider-submenu" class="keen-slider">
              <?php
              foreach ($dataSubMenu as $item) {
                $categoryName = strtolower(str_replace(' ', '-', $item['name']));
              ?>
                <div
                  class="keen-slider__slide"
                  style="
                    min-width: <?php echo strlen($item['name']) * 10 + 12; ?>px;
                    max-width: <?php echo strlen($item['name']) * 10 + 12; ?>px;
                  ">
                  <button
                    class="btn py-2 border-0 text-white fs-8 text-nowrap w-100"
                    onclick="window.location.href='/musical-instrument/category/<?php echo $categoryName; ?>';">
                    <?php echo $item['name']; ?>
                  </button>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
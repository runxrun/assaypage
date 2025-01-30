<div id="keen-slider-thumb" class="keen-slider">
            <?php foreach ($productDetail['prodGallery'] as $item) { ?>
              <div class="keen-slider__slide">
                <button
                  class="btn p-0 border-0 w-100"
                  style="
                    background-image: url('<?php echo $item; ?>');
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: auto 100%;
                  ">
                  <img src="<?php echo $pathURL . 'assets/images/image-ratio-1-1.gif'; ?>" alt="" class="w-100">
                </button>
              </div>
            <?php } ?>
          </div>
          <div id="thumbnails" class="keen-slider thumbnail pt-4">
            <?php foreach ($productDetail['prodGallery'] as $item) { ?>
              <div class="keen-slider__slide">
                <div class="border overflow-hidden">
                  <button
                    class="btn p-0 border-0 w-100"
                    style="
                    background-image: url('<?php echo $item; ?>');
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: auto 100%;
                  ">
                    <img src="<?php echo $pathURL . 'assets/images/image-ratio-4-3.gif'; ?>" alt="" class="w-100">
                  </button>
                </div>
              </div>
            <?php } ?>
          </div>
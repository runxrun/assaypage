<div class="rn-sticky">
  <div class="py-4 pe-md-4">
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
            "
            data-bs-toggle="modal"
            data-bs-target="#galleryModal">

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
  </div>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-truncate">
          Yamaha 6-string series A1M acoustic electric guitar mahogany,
          tobacco sunburst, dreadnought cutaway TBS
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="w-100 text-center p-0">
          <img id="modalImage" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  document.querySelectorAll('[data-bs-target="#galleryModal"]').forEach(button => {
    button.addEventListener('click', function() {
      const imageUrl = this.style.backgroundImage.slice(5, -2);
      document.getElementById('modalImage').src = imageUrl;
    });
  });
</script>

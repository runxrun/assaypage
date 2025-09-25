<div class="border rounded-3 bg-white h-100">
  <div class="d-flex flex-wrap flex-column h-100">
    <div class="w-100 bg-white rounded-top">
      <button
        class="btn p-0 border-0 w-100"
        style="
          background-image: url('<?php echo $item['image']; ?>');
          background-repeat: no-repeat;
          background-position: center;
          background-size: contain;
        "
        onclick="window.location.href = '<?php echo '/musical-instrument/product/' . $item['id']; ?>'">
        <img
          src="<?php echo $pathURL . 'assets/images/image-ratio-4-3.gif'; ?>"
          class="w-100">
      </button>
    </div>
    <div class="w-100">
      <div class="p-3">
        <div class="pb-2 fs-6 fw-bold text-dark">
          <?php echo $item['name']; ?>
        </div>
        <div class="fs-7 text-secondary">
          Nam rerum voluptates magnam! Ipsam, voluptatum exercitationem
          voluptatem sequi praesentium doloremque inventore numquam
        </div>
      </div>
    </div>
    <div class="w-100 mt-auto">
      <div class="p-3">
        <div class="row g-2 align-items-start justify-content-between">
          <div class="col-auto">
            <button
              class="btn btn-warning px-4 fs-8 rounded-pill"
              onclick="window.location.href = '<?php echo '/musical-instrument/product/' . $item['id']; ?>'">
              View more
            </button>
          </div>
          <div class="col-auto">
            <div class="text-end">
              <!-- <div class="fs-4 fw-bold text-dark">
                ฿ 1,000
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
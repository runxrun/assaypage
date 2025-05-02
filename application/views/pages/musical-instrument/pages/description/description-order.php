<div class="py-4">
  <div class="bg-light rounded-2 p-4">
    <div class="d-flex pb-3">
      <div class="pe-2 fs-7 fw-bold text-dark">
        Product Status:
      </div>
      <div class="pe-0 fs-7 text-secondary">
        In stock
      </div>
    </div>
    <div class="border-top pt-3">
      <div class="row g-3 justify-content-between">
        <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-4">
          <?php include(__DIR__.'/../../components/number-picker/number-picker.php'); ?>
        </div>
        <div class="col-12 col-sm-auto">
          <div class="">
            <button class="btn btn-primary rounded-pill px-4 w-100 fs-7" type="button" onclick="window.open('/musical-instrument/cart/', '_self')">
              Add to cart
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 justify-content-between">
  <div class="col-auto">
    <div class="pb-1 fs-7 fw-bold text-dark">
      Important details:
    </div>
    <div class="fs-7 text-secondary">
      <div class="p-0">- Express delivery</div>
      <div class="p-0">- Free nationwide shipping</div>
      <div class="p-0">- 1 year warranty</div>
      <div class="p-0">- Pre and post-sales service</div>
    </div>
  </div>
  <div class="col-auto">
    <div class="d-flex justify-content-end">
      <div class="pe-2 fs-7 text-secondary">
        <i class="fa-solid fa-truck"></i>
      </div>
      <div class="ps-1 fs-7">
        <a href="#shipping" class="fs-7 text-primary text-decoration-none">
          Shipping & Delivery
        </a>
      </div>
    </div>
  </div>
</div>

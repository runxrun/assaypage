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
          <div class="d-flex align-items-center">
            <button class="btn btn-secondary rounded-circle fs-7 p-0" style="min-width: 32px; height: 32px;" type="button" id="button-minus">-</button>
            <div class="px-2 w-100">
              <input type="number" class="form-control rounded-pill h-100 px-2 fs-7 fw-bold text-dark text-center" id="input-number" value="1" min="1" readonly>
            </div>
            <button class="btn btn-secondary rounded-circle fs-7 p-0" style="min-width: 32px; height: 32px;" type="button" id="button-plus">+</button>
          </div>
        </div>
        <div class="col-12 col-sm-auto">
          <div class="">
            <button class="btn btn-primary rounded-pill px-4 w-100 fs-7" type="button">Add to cart</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row justify-content-between">
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

<script type="text/javascript">
  document.getElementById('button-minus').addEventListener('click', function() {
    var input = document.getElementById('input-number');
    var value = parseInt(input.value, 10);
    if (value > 1) {
      input.value = value - 1;
    }
  });

  document.getElementById('button-plus').addEventListener('click', function() {
    var input = document.getElementById('input-number');
    var value = parseInt(input.value, 10);
    if (value < 10) {
      input.value = value + 1;
    }
  });
</script>
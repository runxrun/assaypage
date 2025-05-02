<div class="bg-white border-bottom">
  <div class="container py-2">
    <nav aria-label="breadcrumb" class="m-0 p-0 fs-8">
      <ol class="breadcrumb m-0 p-0">
        <li class="breadcrumb-item"><a href="/musical-instrument/" class="text-primary text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cart</li>
      </ol>
    </nav>
  </div>
</div>
<div class="bg-light py-5 d-none">
  <div class="text-center py-5">
    <div class="pb-4 display-4 text-secondary opacity-50"><i class="fas fa-shopping-cart"></i></div>
    <div class="pb-0 fs-2 fw-bold text-dark">Your cart is currently empty</div>
    <div class="pb-4 fs-5 text-secondary">Browse our categories and discover our best deals!</div>
    <div class="py-4"><a href="/musical-instrument/" class="btn btn-primary rounded-1 py-2 px-4 fs-7">Start Shopping</a></div>
  </div>
</div>
<div class="bg-light">
  <div class="container pt-2 pb-4">
    <div class="row gy-2 gx-3">
      <div class="col-12 col-lg-8 col-xl-9">
        <div class="pt-2">
          <div class="bg-white py-2 px-3 border fs-6 fw-bold text-dark">
            Product List
          </div>
          <?php for ($i = 0; $i < 1; $i++) { ?>
            <div class="bg-white border-start border-end border-bottom">
              <div class="py-3 px-3">
                <div class="row g-3">
                  <div class="col-12 col-sm-4 col-lg-2">
                    <button
                      class="btn border-0 rounded-1 p-0 w-100"
                      style="
                        background-image: url('https://m.media-amazon.com/images/I/61QtWR0r1PL._AC_SX679_.jpg'); 
                        background-repeat: no-repeat;
                        background-position: center; 
                        background-size: contain;
                      "
                      onclick="window.location.href='/musical-instrument/product/0'">
                      <img src="/application/views/pages/musical-instrument/assets/images/image-ratio-4-3.gif" class="w-100">
                    </button>
                  </div>
                  <div class="col-12 col-sm-8 col-lg-10">
                    <div class="pb-2">
                      <a href="/musical-instrument/product/0" class="fs-6 text-decoration-none fw-bold rn-result-link">
                        Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS
                      </a>
                    </div>
                    <div class="pt-0 pb-2 fs-7 text-primary">Guitar</div>
                    <div class="py-3">
                      <div class="row gy-1 gx-4">
                        <div class="col-auto">
                          <div class="fs-7 text-secondary">Price : 70,972.57 ฿</div>
                        </div>
                        <div class="col-auto">
                          <div class="fs-7 text-secondary">Save : 7,097.26 ฿ (10%)</div>
                        </div>
                      </div>
                      <?php
                      /*
                      // STYLE ----------
                      <div class="row gy-1 gx-4">
                        <div class="col-auto">
                          <div class="fs-8 text-secondary text-uppercase">Price </div>
                          <div class="fs-7 fw-bold text-dark">70,972.57 ฿</div>
                          <div class="fs-8 text-danger text-decoration-line-through">78,069.83 ฿</div>
                        </div>
                        <div class="col-auto">
                          <div class="fs-8 text-secondary text-uppercase">Save </div>
                          <div class="fs-7 fw-bold text-dark">7,097.26 ฿</div>
                          <div class="fs-8 text-success">Discount 10 %</div>
                        </div>
                      </div>
                      */
                      ?>
                    </div>
                    <div class="pt-3 border-top">
                      <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-7 col-lg-4">
                          <?php include(__DIR__ . '/../../components/number-picker/number-picker.php'); ?>
                        </div>
                        <div class="col-auto">
                          <div class="">
                            <button class="btn border-0 py-0 px-2 w-100 fs-7 text-secondary" data-bs-toggle="modal" data-bs-target="#removeItemModal">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-12 col-lg-4 col-xl-3">
        <div class="rn-sticky pt-2">
          <div class="bg-white border">
            <div class="py-2 px-3 border-bottom fs-6 fw-bold text-dark">Order Summary</div>
            <div class="py-3 px-3">
              <div class="row gy-1 gx-3 fs-7 text-secondary">
                <div class="col-6 text-start">Price</div>
                <div class="col-6 text-end">78,069.83 ฿</div>
                <div class="col-6 text-start">Save</div>
                <div class="col-6 text-end">- 7,097.26 ฿</div>
                <div class="col-6 text-start">Discount</div>
                <div class="col-6 text-end">10 %</div>
                <!--             
                <div class="col-6 text-start">Promo code</div>
                <div class="col-6 text-end">0.00 ฿</div>
                -->
                <div class="col-6 text-start">Vat</div>
                <div class="col-6 text-end">0.00 ฿</div>
              </div>
            </div>
            <div class="py-3 px-3 border-top">
              <div class="row gy-1 gx-3 fs-6 fw-bold text-dark">
                <div class="col-6 text-start">Price</div>
                <div class="col-6 text-end">70,972.57 ฿</div>
              </div>
            </div>
          </div>
          <div class="py-3">
            <button class="btn btn-primary rounded-1 w-100 fs-7 fw-bold py-3">
              Proceed to order products
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="removeItemModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Remove</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="pb-2 text-center fs-7 fw-bold text-dark">
          Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS
        </div>
        <div class="pb-2 text-center fs-7 text-secondary">
          Are you sure you want to remove this item from your cart?
        </div>
        <div class="py-2 text-center">
          <button type="button" class="btn btn-danger rounded-1 fs-7">Remove item</button>
        </div>
      </div>
    </div>
  </div>
</div>
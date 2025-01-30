<div class="pt-3">
  <div class="border-top pt-3">
    <div class="row gy-2 gx-4">
      <div class="col-auto">
        <div class="fs-2 text-danger">
          <?php echo $productDetail['prodDiscount']; ?>
        </div>
      </div>
      <div class="col-auto">
        <div class="fs-2 text-dark">
          <?php echo '฿' . number_format($productDetail['prodPrice'], 2); ?>
        </div>
      </div>
      <div class="col-12">
        <div class="d-flex">
          <div class="pe-2 fs-7 text-secondary">
            List Price
          </div>
          <div class="pe-0 fs-7 text-secondary text-decoration-line-through">
            <?php echo number_format($productDetail['prodPriceFrom'], 2); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
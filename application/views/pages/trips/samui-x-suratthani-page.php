<br>
<br>
<?php
include_once('data-samui-x-suratthani.php');
$totalPrice = 0;
?>
<div class="py-4">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php
        foreach ($expenses as $item) {
        ?>
          <div class="border-top border-2 border-white text-white">
            <div class="row g-3">
              <div class="col-12 col-md-3">
                <div class="py-3 fw-bold">
                  <?php echo $item['date']; ?>
                </div>
                <div class="d-block d-md-none">
                  <div class="border-bottom border-2 border-white"></div>
                </div>
              </div>
              <div class="col-12 col-md-9">
                <?php foreach ($item['items'] as $key => $value) { ?>
                  <div class="p-0">
                    <?php if ($key > 0) { ?>
                      <div class="p-0">
                        <hr class="m-0 p-0 text-white opacity-25">
                      </div>
                    <?php } ?>
                    <div class="row g-3">
                      <div class="col-6">
                        <div class="py-3 rsp-opacity-50"><?php echo $value['shop']; ?></div>
                      </div>
                      <div class="col-4">
                        <div class="py-3 text-end"><?php echo number_format($value['price'], 2); ?></div>
                      </div>
                      <div class="col-2">
                        <div class="py-3">บาท</div>
                      </div>
                    </div>
                  </div>
                <?php
                  $totalPrice += (float) $value['price'];
                }
                ?>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="border-top border-2 border-white text-white">
          <div class="row g-3">
            <div class="col-12 col-md-3">
              <div class="py-3 d-none d-md-block">
                &nbsp;
              </div>
            </div>
            <div class="col-12 col-md-9">
              <div class="p-0">
                <div class="row g-3">
                  <div class="col-6">
                    <div class="py-3 fw-bold rsp-opacity-50">ผลรวม</div>
                  </div>
                  <div class="col-4">
                    <div class="py-3 text-end fw-bold">
                      <?php echo number_format($totalPrice, 2) ; ?>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="py-3 fw-bold">บาท</div>
                  </div>
                </div>
                
                <div class="p-0">
                  <hr class="m-0 p-0 text-white opacity-25">
                </div>


                <div class="row g-3">
                  <div class="col-6">
                    <div class="py-3 fs-1 rsp-opacity-50">หารกันคนละ</div>
                  </div>
                  <div class="col-4">
                    <div class="py-3 text-end fs-1 text-sp">
                      <?php echo number_format($totalPrice/2, 2) ; ?>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="py-3 fs-1">บาท</div>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
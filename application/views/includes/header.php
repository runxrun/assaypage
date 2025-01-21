<?php
if ($headerAbsolute) {
  $headerSet = 'position-absolute top-0 start-0 w-100';
} else {
  $headerSet = 'position-static w-100';
}
?>

<div class="position-relative w-100">
  <div class="<?php echo $headerSet; ?>">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-auto">
          <div class="py-3">
            <a href="/" class="d-flex">
              <img src="/application/images/assaypage-w.svg" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-auto">
          <div class="d-block d-md-none">
            <div class="">
              <button class="btn text-white border-0 rounded-1 w-100 py-1 px-3 fs-6" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="fas fa-bars"></i>
              </button>
            </div>
          </div>
          <div class="d-none d-md-block">
            <div class="row gy-2 gx-1">
              <?php
              include_once('data-menu.php');
              foreach ($mainMenu as $item) {
              ?>
                <div class="col-auto">
                  <a href="/" class="btn btn-outline-light border-0 rounded-1 w-100 py-1 px-3 fs-6">
                    <?php echo $item['name']; ?>
                  </a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="offcanvas offcanvas-end bg-background" tabindex="-1" id="sidebarMenu">
  <!-- <div class="offcanvas-header">
    <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div> -->
  <div class="offcanvas-body">
    <div>
      <div class="row align-items-center justify-content-between">
        <div class="col-auto">
          <div class="text-white fs-4 text-sp">
            ASSAYPAGE
          </div>
        </div>
        <div class="col-auto">
          <div>
            <button class="btn text-white" data-bs-dismiss="offcanvas">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="py-4">
      <div class="row">
        <?php
        foreach ($mainMenu as $item) {
        ?>
          <div class="col-12">
            <div class="border-bottom rn-border-opacity">
              <a href="/" class="btn btn-outline-light border-0 rounded-1 w-100 py-3 px-0 fs-6">
                <div class="d-flex">
                  <div class="px-2 opacity-50"><?php echo $item['name']; ?></div>
                  <div class="px-2"><?php echo $item['title']; ?></div>
                </div>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<style>
  .rn-border-opacity {
    border-color: rgba(255, 255, 255, 0.25) !important;
  }
</style>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header bg-dark">
    <div class="fs-4 fw-bold text-white">All</div>
    <button type="button" class="btn border-0 fs-4 text-white" data-bs-dismiss="offcanvas" aria-label="Close">
      <i class="fa-solid fa-xmark"></i>
    </button>
  </div>
  <div class="offcanvas-body p-0">

    <?php foreach ($dataSubMenu as $item) { ?>
      <div class="p-0">
        <a href="#" class="d-flex py-2 px-3 text-decoration-none rn-submenu-link">
          <div class="w-100 fs-7">
            <?php echo $item['name']; ?>
          </div>
          <div class="p-0 fs-7">
            <i class="fa-solid fa-chevron-right"></i>
          </div>
        </a>
      </div>
    <?php } ?>


  </div>
</div>
<div class="d-block d-lg-none">
  <button>
    TEST
  </button>
</div>
<div class="rn-sticky- d-none d-lg-block">
  <div class="pt-4 px-4">
    <div class="fs-7 text-secondary">
      Filter
    </div>
  </div>
  <?php
  include(__DIR__ . '/../../mockup/data-filter.php');
  foreach ($dataFilter as $catg => $item) {
  ?>
    <div class="py-2 px-4">
      <div class="border-top pt-2 fs-7 fw-bold text-dark">
        <?php echo $catg; ?>
      </div>
      <div class="py-2">
        <?php foreach (array_slice($item, 0, 10) as $data) { ?>
          <div class="fs-7 text-secondary">
            <?php echo $data; ?>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php
  }
  ?>
</div>
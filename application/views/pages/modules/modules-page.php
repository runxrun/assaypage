<div class="py-2">
  <div class="container">
    <div class="py-4">
      <div class="row g-3">
        <div class="col-auto">
          <a href="/" class="text-white text-decoration-none">
            <div class="d-flex">
              <div class="pe-2 fs-7"><i class="fas fa-arrow-left"></i></div>
              <div class="pe-0 fs-7">Home</div>
            </div>
          </a>
        </div>
        <div class="col-auto">
          <div class="text-white fs-7">
            |
          </div>
        </div>
        <div class="col-auto">
          <div class="text-white fs-7">
            Modules
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container py-4">
  <?php
  $modules = [
    [
      'name' => 'Table responsive',
      'link' => '/modules/table-responsive',
    ],
  ]
  ?>
  <div class="row">
    <?php
    foreach ($modules as $key => $item) {
    ?>
      <div class="col-12 col-lg-3">
        <div class="bg-white rounded-1">
          <a
            href="/modules/table-responsive"
            class="d-block p-4 text-center text-decoration-none">
            <div class="pb-1 fs-7 fw-bold text-dark text-uppercase">Table responsive</div>
            <div class="pb-0 fs-8 text-secondary">CSS for making the table responsive</div>
          </a>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>

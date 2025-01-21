<div class="container">

  <div class="pt-4">
    <div class="d-flex border-bottom py-2 px-0">
      <div class="text-white fw-bold">Web Templates</div>
    </div>
    <div class="py-2">
      <div class="row gy-2 gx-3 fs-7">
        <?php
        include(__dir__ . '/data-webtemplates.php');
        foreach ($weblists as $item) {
        ?>
          <div class="col-auto">
            <div class="d-flex fs-8 text-white">
              <div class="pe-2">
                <small><i class="fas fa-chevron-right"></i></small>
              </div>
              <div class="pe-2">
                <a href="<?php echo $item['link']; ?>" target="_blank" class="text-white text-decoration-none">
                  <?php echo $item['name']; ?>
                </a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
  <div class="pt-4">
    <div class="d-flex border-bottom py-2 px-0">
      <div class="text-white fw-bold">Bygone Journeys</div>
    </div>
    <div class="py-2">
      <div class="row gy-2 gx-3 fs-7">

        <?php
        include_once(__DIR__ . '/../pages/journeys/data-journeys.php');
        foreach ($dataJourneys as $item) {
          $preLink = strtolower('/journeys/' . $item['country']);
          $link = str_replace(' ', '-', $preLink);
          $name = $item['country'];
        ?>
          <div class="col-auto">
            <div class="d-flex fs-8 text-white">
              <div class="pe-2">
                <small><i class="fas fa-chevron-right"></i></small>
              </div>
              <div class="pe-2">
                <a href="<?php echo $link; ?>" class="text-white text-decoration-none">
                  <?php echo $name; ?>
                </a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>



      </div>
    </div>
  </div>
  <div class="pt-4">
    <div class="row gy-2 gx-3 justify-content-center">
      <div class="col-auto"><a target="_blank" class="fs-2 text-white" href="https://www.instagram.com/runextreme/"><i class="fab fa-instagram"></i></a></div>
      <div class="col-auto"><a target="_blank" class="fs-2 text-white" href="https://www.facebook.com/nirv.vana.9"><i class="fab fa-facebook-square"></i></a></div>
      <div class="col-auto"><a target="_blank" class="fs-2 text-white" href="https://www.linkedin.com/in/nirv-vana-8897132a/"><i class="fab fa-linkedin"></i></a></div>
    </div>
  </div>
  <div class="pt-3 pb-4">
    <div class="text-center text-white fs-8">
      COPYRIGHT &copy; 2024 - ASSAYPAGE.
      POWERED BY RUNXRUN
    </div>
  </div>
</div>
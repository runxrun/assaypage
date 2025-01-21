<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Microsites</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/application/scss/custom.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</head>

<body class="bg-light">
  <?php
  include 'microsites-data.php';
  ?>
  <div class="bg-dark">
    <div class="container py-3">
      <div class="row">
        <div class="col-auto">
          <div class="fs-5 fw-bold text-white">
            MICROSITES
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-4">
    <div class="container py-4">
      <div class="pb-4">
        <div class="row g-2" role="tablist">
          <div class="col-auto">
            <button
              class="btn fs-7 text-dark rounded-0 px-4 active"
              data-bs-toggle="tab"
              data-bs-target="#second-tab-pane"
              type="button"
              role="tab"
              aria-controls="second-tab-pane"
              aria-selected="true">
              Generation #2
            </button>
          </div>
          <div class="col-auto">
            <button
              class="btn fs-7 text-dark rounded-0 px-4"
              data-bs-toggle="tab"
              data-bs-target="#first-tab-pane"
              type="button"
              role="tab"
              aria-controls="first-tab-pane"
              aria-selected="false">
              Generation #1
            </button>
          </div>
        </div>
        <div class="tab-content pt-4">
          <div
            class="tab-pane fade"
            id="first-tab-pane"
            role="tabpanel"
            aria-labelledby="first-tab"
            tabindex="0">
            <div class="row g-3">
              <?php
              foreach ($microsites_first as $first) {
              ?>
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="d-flex flex-wrap flex-column border rounded-0 bg-white h-100">

                    <div class="w-100">
                      <div class="row g-0 justify-content-between">
                        <div class="col-8">
                          <div class="pt-2 px-3 fs-6 fw-bold text-dark text-break">
                            <?php echo $first['name']; ?>
                          </div>
                        </div>
                        <div class="col-auto">
                          <div class="pt-2 px-3 fs-7 text-secondary">
                            <?php echo $first['code']; ?>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="pt-2 px-3 pb-3 text-secondary fs-8">
                            <div class="d-flex align-items-center pb-1">
                              <div
                                style="
                                  background-color: <?php echo $first['color']; ?>;
                                  width: 16px;
                                  height: 16px;
                                  border-radius: 50%;
                                ">
                              </div>
                              <div class="ps-2 text-truncate"><?php echo $first['color']; ?></div>
                            </div>
                            <div class="text-truncate"><?php echo $first['site']; ?></div>
                            <div class="text-truncate"><?php echo $first['manage']; ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mt-auto w-100">
                      <div class="d-flex">
                        <div class="w-100 border-top">
                          <a
                            href="<?php echo $first['site']; ?>"
                            class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
                            target="_blank">
                            Website
                          </a>
                        </div>
                        <div class="w-100 border-top border-start">
                          <a
                            href="<?php echo $first['manage']; ?>"
                            class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
                            target="_blank">
                            Manage
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <div
            class="tab-pane fade show active"
            id="second-tab-pane"
            role="tabpanel"
            aria-labelledby="second-tab"
            tabindex="0">


            <div class="row g-3">
              <?php
              foreach ($microsites as $microsite) {
              ?>
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="d-flex flex-wrap flex-column border rounded-0 bg-white h-100">

                    <div class="w-100">
                      <div class="row g-0 justify-content-between">
                        <div class="col-8">
                          <div class="pt-2 px-3 fs-6 fw-bold text-dark text-break">
                            <?php echo $microsite['name']; ?>
                          </div>
                        </div>
                        <div class="col-auto">
                          <div class="pt-2 px-3 fs-7 text-secondary">
                            <?php echo $microsite['code']; ?>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="pt-2 px-3 pb-3 text-secondary fs-8">
                            <div class="d-flex align-items-center pb-1">
                              <div
                                style="
                                  background-color: <?php echo $microsite['color']; ?>;
                                  width: 16px;
                                  height: 16px;
                                  border-radius: 50%;
                                ">
                              </div>
                              <div class="ps-2 text-truncate"><?php echo $microsite['color']; ?></div>
                            </div>
                            <div class="text-truncate"><?php echo $microsite['site']; ?></div>
                            <div class="text-truncate"><?php echo $microsite['manage']; ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mt-auto w-100">
                      <div class="d-flex">
                        <div class="w-100 border-top">
                          <a
                            href="<?php echo $microsite['site']; ?>"
                            class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
                            target="_blank">
                            Website
                          </a>
                        </div>
                        <div class="w-100 border-top border-start">
                          <a
                            href="<?php echo $microsite['manage']; ?>"
                            class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
                            target="_blank">
                            Manage
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="py-4">

      </div>
      <div class="py-4">
        <span class="fs-8 text-secondary">
          Information about the microsites can be found
        </span>
        <a
          href="https://drive.google.com/drive/folders/1OkjBuFs7x4bwlIOFA7HiemUN1RXPshE6"
          class="fs-8 text-decoration-underline text-secondary"
          target="_blank">
          click here
        </a>
      </div>
    </div>
  </div>
  </div>
</body>

</html>
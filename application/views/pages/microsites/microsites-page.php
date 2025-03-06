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
  include 'microsites-template.php';
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
              data-bs-target="#third-tab-pane"
              type="button"
              role="tab"
              aria-controls="third-tab-pane"
              aria-selected="true">
              Batch #3
            </button>
          </div>
          <div class="col-auto">
            <button
              class="btn fs-7 text-dark rounded-0 px-4"
              data-bs-toggle="tab"
              data-bs-target="#second-tab-pane"
              type="button"
              role="tab"
              aria-controls="second-tab-pane"
              aria-selected="true">
              Batch #2
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
              Batch #1
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
              foreach ($microsites_first as $microsite) {
                $output = $template;
                $output = str_replace('{{name}}', $microsite['name'], $output);
                $output = str_replace('{{code}}', $microsite['code'], $output);
                $output = str_replace('{{color}}', $microsite['color'], $output);
                $output = str_replace('{{site}}', $microsite['site'], $output);
                $output = str_replace('{{manage}}', $microsite['manage'], $output);
                $output = str_replace('{{logo}}', $microsite['logo'], $output);
                echo $output;
              }
              ?>
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="second-tab-pane"
            role="tabpanel"
            aria-labelledby="second-tab"
            tabindex="0">
            <div class="row g-3">
              <?php
              foreach ($microsites as $microsite) {
                $output = $template;
                $output = str_replace('{{name}}', $microsite['name'], $output);
                $output = str_replace('{{code}}', $microsite['code'], $output);
                $output = str_replace('{{color}}', $microsite['color'], $output);
                $output = str_replace('{{site}}', $microsite['site'], $output);
                $output = str_replace('{{manage}}', $microsite['manage'], $output);
                $output = str_replace('{{logo}}', $microsite['logo'], $output);
                echo $output;
              }
              ?>
            </div>
            <div class="pt-5 pb-4">
              <span class="fs-8 text-secondary">
                Information about the microsites (2) can be found
              </span>
              <a
                href="https://drive.google.com/drive/folders/1OkjBuFs7x4bwlIOFA7HiemUN1RXPshE6"
                class="fs-8 text-decoration-underline text-secondary"
                target="_blank">
                click here
              </a>
            </div>
          </div>

          <div
            class="tab-pane fade show active"
            id="third-tab-pane"
            role="tabpanel"
            ria-labelledby="third-tab"
            tabindex="0">
            <div class="row g-3">
              <?php
              foreach ($microsites_3 as $microsite) {
                $output = $template;
                $output = str_replace('{{name}}', $microsite['name'], $output);
                $output = str_replace('{{code}}', $microsite['code'], $output);
                $output = str_replace('{{color}}', $microsite['color'], $output);
                $output = str_replace('{{site}}', $microsite['site'], $output);
                $output = str_replace('{{manage}}', $microsite['manage'], $output);
                $output = str_replace('{{logo}}', $microsite['logo'], $output);
                echo $output;
              }
              ?>
            </div>
            <div class="pt-5 pb-4">
              <span class="fs-8 text-secondary">
                Information about the microsites (3) can be found
              </span>
              <a
                href="https://docs.google.com/spreadsheets/d/1xBWZjRv2VPFnRkVNDyotu2oLjzJ9FHNKOz9rJ2dPdNU/edit?gid=1607529945#gid=1607529945"
                class="fs-8 text-decoration-underline text-secondary"
                target="_blank">
                click here
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="py-4">
        <?php
        /*
        foreach ($microsites_3 as $key => $microsite) {
        ?>
          <div class=""> &lt;Folder expanded="1"&gt;<?php echo $key < 9 ? '0' : ''; ?><?php echo $key + 1; ?>. <?php echo $microsite['name']; ?></div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&lt;Server&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Host&gt;23.106.52.133&lt;/Host&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Port&gt;1188&lt;/Port&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Protocol&gt;1&lt;/Protocol&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Type&gt;0&lt;/Type&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;User&gt;11infoadm1&lt;/User&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Pass encoding="base64"&gt;cnBhY2hlaWl0ZWNoIQ==&lt;/Pass&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Logontype&gt;1&lt;/Logontype&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;EncodingType&gt;Auto&lt;/EncodingType&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;BypassProxy&gt;0&lt;/BypassProxy&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Name&gt;<?php echo str_replace('https://','',$microsite['manage']);?>&lt;/Name&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Comments&gt;11infoadm1 rpacheiitech!&lt;/Comments&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;RemoteDir&gt;&lt;/RemoteDir&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;SyncBrowsing&gt;0&lt;/SyncBrowsing&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;DirectoryComparison&gt;0&lt;/DirectoryComparison&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&lt;/Server&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&lt;Server&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Host&gt;23.106.52.133&lt;/Host&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Port&gt;1188&lt;/Port&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Protocol&gt;1&lt;/Protocol&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Type&gt;0&lt;/Type&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;User&gt;11infoadm1&lt;/User&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Pass encoding="base64"&gt;cnBhY2hlaWl0ZWNoIQ==&lt;/Pass&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Logontype&gt;1&lt;/Logontype&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;EncodingType&gt;Auto&lt;/EncodingType&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;BypassProxy&gt;0&lt;/BypassProxy&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Name&gt;<?php echo str_replace('https://','',$microsite['site']);?>&lt;/Name&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Comments&gt;11infoadm1 rpacheiitech!&lt;/Comments&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;RemoteDir&gt;&lt;/RemoteDir&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;SyncBrowsing&gt;0&lt;/SyncBrowsing&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;DirectoryComparison&gt;0&lt;/DirectoryComparison&gt;</div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;&lt;/Server&gt;</div>
          <div>&lt;/Folder&gt;</div>
        <?php
        }
        */
        ?>
      </div>
    </div>
  </div>

  <?php


  // $template = '
  // <div class="col-12 col-md-6 col-lg-4">
  //     <div class="d-flex flex-wrap flex-column border rounded-0 bg-white h-100">
  //       <div class="w-100">
  //         <div class="row g-0 justify-content-between">
  //           <div class="col-8">
  //             <div class="pt-2 px-3 fs-6 fw-bold text-dark text-break">
  //               ' . $microsite['name'] . '
  //             </div>
  //           </div>
  //           <div class="col-auto">
  //             <div class="pt-2 px-3 fs-7 text-secondary">
  //               ' . $microsite['code'] . '
  //             </div>
  //           </div>
  //           <div class="col-12">
  //             <div class="pt-2 px-3 pb-3 text-secondary fs-8">
  //               <div class="d-flex align-items-center pb-1">
  //                 <div
  //                   style="
  //                     background-color: ' . $microsite['color'] . ';
  //                     width: 16px;
  //                     height: 16px;
  //                     border-radius: 50%;
  //                   ">
  //                 </div>
  //                 <div class="ps-2 text-truncate">' . $microsite['color'] . '</div>
  //               </div>
  //               <div class="text-truncate">' . $microsite['site'] . '</div>
  //               <div class="text-truncate">' . $microsite['manage'] . '</div>
  //             </div>
  //           </div>
  //         </div>
  //       </div>
  //       <div class="mt-auto w-100">
  //         <div class="d-flex">
  //           <div class="w-100 border-top">
  //             <a
  //               href="' . $microsite['site'] . '"
  //               class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
  //               target="_blank">
  //               Website
  //             </a>
  //           </div>
  //           <div class="w-100 border-top border-start">
  //             <a
  //               href="' . $microsite['manage'] . '"
  //               class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
  //               target="_blank">
  //               Manage
  //             </a>
  //           </div>
  //         </div>
  //       </div>
  //     </div>
  //   </div>
  // ';

  ?>
</body>

</html>
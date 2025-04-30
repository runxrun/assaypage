<div class="py-2">
  <div class="container">
    <div class="py-4">
      <div class="row g-3">
        <div class="col-auto">
          <a href="/modules/" class="text-white text-decoration-none">
            <div class="d-flex">
              <div class="pe-2 fs-7"><i class="fas fa-arrow-left"></i></div>
              <div class="pe-0 fs-7">Module</div>
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
            Interactive Width Expansion
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<link rel="stylesheet" href="/application/views/pages/modules/components/interactive-width-expansion/iwe.css">


<?php

$dataIWE = [
  [
    'name' => 'Responsive Design',
    'desc' => 'Techniques to create web pages that adapt to different screen sizes.',
    'link' => '/modules/',
  ],
  [
    'name' => 'Machine Learning',
    'desc' => 'Algorithms that allow computers to learn from data and improve over time.',
    'link' => '/modules/',
  ],
  [
    'name' => 'Cloud Computing',
    'desc' => 'Delivery of computing services over the internet.',
    'link' => '/modules/',
  ],
  [
    'name' => 'Cybersecurity',
    'desc' => 'Practices to protect systems and networks from digital attacks.',
    'link' => '/modules/',
  ],
];

?>



<div class="container">
  <div class="py-4">
    <div class="rn-iwe">
      <?php foreach ($dataIWE as $item) { ?>
        <div class="bg-white rounded-1 rn-iwe-item">
          <div class="d-flex w-100 h-100 flex-column">
            <div class="p-0">
              <div class="row justify-content-between">
                <div class="col-auto">&nbsp;</div>
                <div class="col-auto">
                  <a href="<?php echo $item['link']; ?>" class="btn border-0 py-2 px-3 text-secondary text-decoration-none" style="transform: rotate(-45deg);">
                    <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="mt-auto p-3">
              <div class="pb-1 fs-5 fw-bold text-dark"><?php echo $item['name']; ?></div>
              <div class="fs-8 text-secondary"><?php echo $item['desc']; ?></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
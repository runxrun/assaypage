<?php
$dataB = [
  ['title' => 'ACXCD', 'desc' => 'Lorem ipsum, dolor sit amet consectetur aporro repudiandae  dipisicing elit amet consectetur', 'icon' => '<i class="fas fa-database"></i>',],
  ['title' => 'QWEER', 'desc' => 'Laudantium tenetur porro repud iandae corporis excepturi inventore quo enim cum, voluptatem', 'icon' => '<i class="fas fa-server"></i>',],
  ['title' => 'POIUK', 'desc' => 'Cupiditate excepturi inventore quo enim cum tenetur porro repudiandae corporis saepe elit amet', 'icon' => '<i class="fas fa-mouse"></i>',],
];
?>
<div class="pb-4">
  <div class="row justify-content-center g-4">
    <?php
    foreach ($dataB as $item) {
    ?>
      <div class="col-12 col-sm-4 col-lg-3">
        <div class="pb-4 px-0 px-lg-4">
          <div class="row g-3">
            <div class="col-4 col-sm-12">
              <div class="pt-2 display-4 text-white text-center rn-gradient">
                <?php echo $item['icon']; ?>
              </div>
            </div>
            <div class="col-8 col-sm-12">
              <div class="fs-3 text-white text-sm-center text-sp">
                <?php echo $item['title']; ?>
              </div>
              <div class="pt-2 fs-7 text-white text-sm-center opacity-50">
                <?php echo $item['desc']; ?>
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
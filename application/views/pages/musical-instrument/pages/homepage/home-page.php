<div class="container-fluid">
  <div class="p-2 p-lg-4">
    <div class="row justify-content-center g-3">
      <div class="col-12 col-lg-8">
        <div class="py-3 fs-2 text-dark fw-bold text-center">
          MUSIC INSTRUMENTS
        </div>
        <div class="pb-3 fs-6 text-secondary text-center">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. In quibusdam consequatur quidem
          reprehenderit porro odio, illum nesciunt totam harum. Adipisci eum quam temporibus
          distinctio facilis placeat cumque in omnis at. Libero sit animi accusantium et cumque consequuntur.
        </div>
        <div class="py-3">
          <div class="row justify-content-center g-3">
            <div class="col-auto">
              <button class="btn btn-outline-secondary px-4 fs-7 rounded-pill">
                View more
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="p-2 p-lg-4">
    <div class="navigation-wrapper">
      <?php
      $data = array(
        array('id' => 1, 'name' => 'Ratione eligendi ad commodi earum voluptas'),
        array('id' => 2, 'name' => 'Illum nesciunt totam harum'),
        array('id' => 3, 'name' => 'Adipisci eum quam temporibus distinctio'),
        array('id' => 4, 'name' => 'Dolor sit amet consectetur adipisicing elit'),
        array('id' => 5, 'name' => 'Assumenda quos officia animi asperiores voluptates'),
        array('id' => 6, 'name' => 'Libero sit animi accusantium et cumque consequuntur'),
        array('id' => 7, 'name' => 'Consequatur eaque molestiae quisquam'),
        array('id' => 8, 'name' => 'Voluptatum, repudiandae nemo asperiores iste laboriosa'),
        array('id' => 9, 'name' => 'Impedit maiores voluptatem voluptatibus iusto nesciunt'),
        array('id' => 0, 'name' => 'Cupiditate ullam dolores delectus laboriosam')
      );
      ?>
      <div id="keen-slider-card" class="keen-slider">
        <?php foreach ($data as $item) { ?>
          <div class="keen-slider__slide">
            <?php include(__DIR__ . '/../../components/card/card-01.php'); ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="p-2 p-lg-4">
    <div class="row g-2">
      <div class="col-12">
        <div class="bg-primary">
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
        </div>
      </div>
      <?php
      $bgArray[0] = 'bg-warning';
      $bgArray[1] = 'bg-danger';
      $bgArray[2] = 'bg-success';
      $bgArray[3] = 'bg-info';
      for ($i = 0; $i < 4; $i++) {
      ?>
        <div class="col-12 col-md-6">
          <div class="<?php echo $bgArray[$i]; ?>">
            <br><br><br><br>
            <br><br><br><br>
            <br><br><br><br>
            <br><br><br><br>
            <br><br><br><br>
            <br><br><br><br>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>


<!-- <img src="?php echo $pathURL. 'assets/images/image-ratio-16-9.gif';?>" class="w-100"> -->
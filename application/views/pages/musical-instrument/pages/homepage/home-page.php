<div class="bg-white">
  <?php include_once(__DIR__ . '/../../components/banners/home-banner.php'); ?>
  <div class="container-fluid">
    <div class="p-0 p-lg-4">
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
                <button class="btn btn-outline-secondary px-4 fs-7 rounded-pill" onclick="window.location.href = '/musical-instrument/about-us';">
                  View more
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-4">
      <div class="container">
        <div class="pb-3 fs-5 fw-bold text-dark">
          Product categories
        </div>
        <div class="">
          <div class="row g-3">
            <?php
            $prodCatg = [
              ['id' => 2, 'name' => 'Piano'],
              ['id' => 3, 'name' => 'Drums'],
              ['id' => 1, 'name' => 'Guitar'],
              ['id' => 4, 'name' => 'Violin'],
              ['id' => 6, 'name' => 'Cello'],
              ['id' => 4, 'name' => 'Clarinet'],
              ['id' => 4, 'name' => 'Saxophone'],
              ['id' => 5, 'name' => 'Trumpet'],
            ];
            foreach ($prodCatg as $category) {
            ?>
              <div class="col-6 col-md-3">
                <button class="btn fw-bold text-dark fs-6 w-100 p-4 border rounded-2">
                  <?php echo $category['name']; ?>
                </button>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="p-0 p-lg-4">
      <div class="container">
        <div class="pb-3 fs-5 fw-bold text-dark">
          Product recommended
        </div>
        <div class="navigation-wrapper">
          <?php
          $data = array(
            array('id' => 1, 'name' => 'Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS', 'image' => 'https://m.media-amazon.com/images/I/61QtWR0r1PL._AC_SX679_.jpg'),
            array('id' => 2, 'name' => 'RockJam 61 Key Keyboard Piano Stand With Pitch Bend Kit, Piano Bench, Headphones, Simply Piano App & Keynote Stickers', 'image' => 'https://m.media-amazon.com/images/I/71s2McIHUeL._AC_SX679_.jpg'),
            array('id' => 3, 'name' => 'Eastar Bb Standard Trumpet Set for Beginner, Brass Student Trumpet Instrument with Hard Case, Cleaning Kit, 7C Mouthpiece and Gloves, ETR-380, Golden', 'image' => 'https://m.media-amazon.com/images/I/71aJQDkdE7L._AC_SY300_SX300_QL70_FMwebp_.jpg'),
            array('id' => 4, 'name' => 'Miniature Timpani with Case Mini Percussion Musical Instrument Replica Collectible Dollhouse Accessories Model Home Ornament (Timpani)', 'image' => 'https://m.media-amazon.com/images/I/61QZe39f6pL._AC_SX679_.jpg'),
            array('id' => 5, 'name' => 'Soulmate Clarinet for Beginner Student Adults 17 Keys Bb Clarinet Set with 2 Barrels Hard Case 10 Reeds and Cleaning Kit, Professional Black', 'image' => 'https://m.media-amazon.com/images/I/711FLPtt4-L._AC_SX679_.jpg'),
            array('id' => 6, 'name' => 'Crossrock Poly Carbon Cello Case for 4/4 Full Size | Black Scratch-Resistant Shell, Black Velvet Interior, Wheels, Music Pouch – Lightweight Protection Series', 'image' => 'https://m.media-amazon.com/images/I/71o3YNKjPyL._AC_SX679_.jpg'),
            array('id' => 7, 'name' => 'Cecilio Violin 4/4 Full Size Kit Hand Oil Rub Highly Flamed 1-Piece Back Solidwood Violin with D’Addario Prelude Strings, Size 4/4 (Full Size)', 'image' => 'https://m.media-amazon.com/images/I/818bcf9nZ9L._AC_SX679_.jpg'),
            array('id' => 8, 'name' => 'EASTROCK Xylophone - 27 Notes Glockenspiel for Kids, Professional Instrument for Music Teaching - Includes 2 Wooden Beaters and Black Carry Case', 'image' => 'https://m.media-amazon.com/images/I/71FdckLQ1YL._AC_SX679_.jpg'),
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
    </div>
  </div>
  <div class="p-0 p-lg-4">
    <div class="container">
      <div class="py-3">
        <div id="keen-slider-banner" class="keen-slider">
          <?php foreach ($data as $item) { ?>
            <div class="keen-slider__slide">
              <div class="bg-secondary text-white text-center">
                <br><br><br><br>
                <?php echo $item['name']; ?>
                <br><br><br><br>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="py-3">
        <div class="row g-3">
          <?php
          $array = [0, 1, 2, 3];
          foreach ($array as $item) {
          ?>
            <div class="col-6 col-md-3">
              <div class="bg-secondary">
                <img src="<?php echo $pathURL . 'assets/images/image-ratio-4-3.gif'; ?>" class="w-100">
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- <img src="?php echo $pathURL. 'assets/images/image-ratio-16-9.gif';?>" class="w-100"> -->
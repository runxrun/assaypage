<?php

if (empty($segment[1])) {
  exit();
}

$filteredCountry = strtoupper(str_replace('-',' ', $segment[1]));
include_once('data-journeys.php');

// $dataCountry = 'No data';
// $dataCity = 'Data not found';

$dataCountry = [];
$dataCity = [];

foreach ($dataJourneys as $item) {
  if (strtoupper($item['country']) == $filteredCountry) {
    $dataCountry = $item['country'];
    $dataCity = [];
    foreach ($item['city'] as $city) {
      $dataCity[] = $city;
    }
    break;
  }
}

?>

<div class="container">
  <div class="rn-navigator rounded-1 py-2 px-2">
    <div class="py-1">
      <div class="row g-2">
        <div class="col-auto">
          <div class="px-2 fs-8 text-white opacity-50">
            <i class="fas fa-home"></i>
          </div>
        </div>
        <div class="col-auto">
          <div class="fs-8 text-white opacity-50">Journeys</div>
        </div>
        <div class="col-auto">
          <div class="fs-8 text-white opacity-50">/</div>
        </div>
        <div class="col-auto">
          <div class="fs-8 text-white opacity-50"><?php echo $dataCountry; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="py-4">
  <div class="container">
    <div class="row g-3">
      <?php
      foreach ($dataCity as $value) {
        $hasBeen = $value['been'] ? 'text-success pe-2' : 'text-white pe-2 opacity-25';
        $hasBeenTxt = $value['been'] ? 'fs-6 text-white' : 'fs-6 text-white opacity-25';
        $hasBeenSubTxt = $value['been'] ? 'fs-9 text-white opacity-50' : 'fs-9 text-white opacity-25';
      ?>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="d-flex">
            <div class="<?php echo $hasBeen; ?>"><i class="fas fa-check-circle"></i></div>
            <div class="p-0">
              <div class="<?php echo $hasBeenTxt; ?>"><?php echo $value['nameLocale']; ?></div>
              <div class="<?php echo $hasBeenSubTxt; ?>"><?php echo $value['name']; ?></div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>

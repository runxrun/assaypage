<?php

$microsites = [
  [
    'site' => 'https://www.artotelsimpangtemu.com',
    'manage' => 'https://manage.artotelsimpangtemu.com',
    'code' => 'CL250'
  ],
  [
    'site' => 'https://www.artotelhanimanubud.com',
    'manage' => 'https://manage.artotelhanimanubud.com',
    'code' => 'CL251'
  ],
  [
    'site' => 'https://www.artotelsanurbali.com',
    'manage' => 'https://manage.artotelsanurbali.com',
    'code' => 'CL245'
  ],
  [
    'site' => 'https://www.artotelbatam.com',
    'manage' => 'https://manage.artotelbatam.com',
    'code' => 'CL253'
  ],
  [
    'site' => 'https://www.artotelyogyakarta.com',
    'manage' => 'https://manage.artotelyogyakarta.com',
    'code' => 'CL254'
  ],
  [
    'site' => 'https://www.artotelgajahmadasemarang.com',
    'manage' => 'https://manage.artotelgajahmadasemarang.com',
    'code' => 'CL255'
  ],
  [
    'site' => 'https://www.vuepalaceartotelcurated.com',
    'manage' => 'https://manage.vuepalaceartotelcurated.com',
    'code' => 'CL256'
  ],
  [
    'site' => 'https://www.debragabandungbyartotel.com',
    'manage' => 'https://manage.debragabandungbyartotel.com',
    'code' => 'CL257'
  ],
  [
    'site' => 'https://www.thereizsuitesmedanartotelcurated.com',
    'manage' => 'https://manage.thereizsuitesmedanartotelcurated.com',
    'code' => 'CL258'
  ],
  [
    'site' => 'https://www.thegreenpeakartotelcurated.com',
    'manage' => 'https://manage.thegreenpeakartotelcurated.com',
    'code' => 'CL259'
  ],
  [
    'site' => 'https://www.viverehotelartotelcurated.com',
    'manage' => 'https://manage.viverehotelartotelcurated.com',
    'code' => 'CL260'
  ],
  [
    'site' => 'https://www.mierskuninganartotelcurated.com',
    'manage' => 'https://manage.mierskuninganartotelcurated.com',
    'code' => 'CL261'
  ],
  [
    'site' => 'https://www.sparkslifejakartaartotelcurated.com',
    'manage' => 'https://manage.sparkslifejakartaartotelcurated.com',
    'code' => 'CL262'
  ],
  [
    'site' => 'https://www.artotelcasacikarang.com',
    'manage' => 'https://manage.artotelcasacikarang.com',
    'code' => 'CL263'
  ],
  [
    'site' => 'https://www.artotelcasakuningan.com',
    'manage' => 'https://manage.artotelcasakuningan.com',
    'code' => 'CL264'
  ],
  [
    'site' => 'https://www.artoteltssuites.com',
    'manage' => 'https://manage.artoteltssuites.com',
    'code' => 'CL265'
  ],
  [
    'site' => 'https://www.artotelcabinbromo.com',
    'manage' => 'https://manage.artotelcabinbromo.com',
    'code' => 'CL246'
  ],
  [
    'site' => 'https://www.roomsincsemarang.com',
    'manage' => 'https://manage.roomsincsemarang.com',
    'code' => 'CL267'
  ],
  [
    'site' => 'https://www.roomsincbandung.com',
    'manage' => 'https://manage.roomsincbandung.com',
    'code' => 'CL268'
  ],
  [
    'site' => 'https://www.myzehotelsumenep.com',
    'manage' => 'https://manage.myzehotelsumenep.com',
    'code' => 'CL269'
  ]
];

echo '<div class="container py-4">';
echo '<div class="row g-3">';
foreach ($microsites as $microsite) {
  echo '<div class="col-md-4">
    <div class="text-white fs-7">
    
        <h5 class="card-title">' . $microsite['code'] . '</h5>
        <p class="card-text">' . $microsite['site'] . '</p>
        <a href="' . $microsite['site'] . '" class="btn btn-outline-primary fs-8" target="_blank">Visit Site</a>
        <a href="' . $microsite['manage'] . '" class="btn btn-outline-primary fs-8" target="_blank">Manage Site</a>
      </div>
  </div>';
}
echo '<div class="col-12"><a href="https://drive.google.com/drive/folders/1OkjBuFs7x4bwlIOFA7HiemUN1RXPshE6" target="_blank">Google Drive</a></div>';
echo '</div>';
echo '</div>';

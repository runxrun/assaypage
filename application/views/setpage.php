<?php

$title = "ASSAYPAGE";

switch (strtoupper($segment[0])) {
  case "":
    $page = __DIR__ . '/pages/homepage/homepage.php';
    $title = "ASSAYPAGE - アッサイページ";
    $headerAbsolute = true;
    break;
  case "JOURNEYS":
    $page = __DIR__ . '/pages/journeys/journeys-page.php';
    $title = "Journeys - 旅";
    break;
  case "TRIP-SAMUI-X-SURATTHANI":
    $title = "Journeys - サムイ島とスラタニへの旅";
    $page = __DIR__ . '/pages/trips/samui-x-suratthani-page.php';
    break;
  case "MODULES":
    if (strtoupper($segment[1])) {
      switch (strtoupper($segment[1])) {
        case "TABLE-RESPONSIVE":
          $page = __DIR__ . '/pages/modules/components/table-responsive/index.php';
          $title = "Table Responsive - テーブルレスポンシブ";
          break;
        case "PARALLAX":
          $page = __DIR__ . '/pages/modules/components/parallax/index.php';
          $title = "Parallax - 視差";
          break;
        case "INFINITE-SCROLL":
          $page = __DIR__ . '/pages/modules/components/infinite-scroll/index.php';
          $title = "Infinite Scroll - 無限スクロール";
          break;
      }
    } else {
      $page = __DIR__ . '/pages/modules/modules-page.php';
      $title = "Modules - モジュール";
    }
    break;
  default:
    $page = __DIR__ . '/pages/filenotfound/filenotfound.php';
    break;
}

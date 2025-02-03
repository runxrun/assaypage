<?php

switch (strtoupper($segment[1])) {
	case '':
		$currentPage = __DIR__ . '/pages/homepage/home-page.php';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider .= '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-card.js"></script>';
		$scriptKeenSlider .= '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-banner.js"></script>';
		break;
	case 'CATEGORY':
		$currentPage = __DIR__ . '/pages/result/result-page.php';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'PRODUCT':
		$currentPage = __DIR__ . '/pages/description/description-page.php';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider .= '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-gallery.js"></script>';
		break;
	default:
		echo '404';
		break;
}

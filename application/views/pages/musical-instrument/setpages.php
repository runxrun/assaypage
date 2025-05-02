<?php

switch (strtoupper($segment[1])) {
	case '':
		$currentPage = __DIR__ . '/pages/homepage/home-page.php';
		$htmlTitle = 'Musical Instruments';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider .= "\n". '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-card.js"></script>';
		$scriptKeenSlider .= "\n". '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-banner.js"></script>';
		break;
	case 'CATEGORY':
		$currentPage = __DIR__ . '/pages/result/result-page.php';
		$htmlTitle = 'Category - Musical Instruments';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'PRODUCT':
		$currentPage = __DIR__ . '/pages/description/description-page.php';
		$htmlTitle = 'Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider .= "\n". '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-gallery.js"></script>';
		break;
	case 'CART':
		$currentPage = __DIR__ . '/pages/cart/cart-page.php';
		$htmlTitle = 'Cart - Musical Instruments';
		// $scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	default:
		$currentPage = __DIR__ . '/pages/filenotfound/filenotfound-page.php';
		$scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
}

<?php

switch (strtoupper($segment[1])) {
	case '':
		$currentPage = __DIR__ . '/pages/homepage/home-page.php';
		$htmlTitle = 'Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider .= "\n" . '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-card.js"></script>';
		$scriptKeenSlider .= "\n" . '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-banner.js"></script>';
		break;
	case 'CATEGORY':
		$currentPage = __DIR__ . '/pages/result/result-page.php';
		$htmlTitle = 'Category - Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'PRODUCT':
		$currentPage = __DIR__ . '/pages/description/description-page.php';
		$htmlTitle = 'Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider .= "\n" . '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-gallery.js"></script>';
		break;
	case 'CART':
		$currentPage = __DIR__ . '/pages/cart/cart-page.php';
		$htmlTitle = 'Cart - Musical Instruments';
		// $scriptKeenSlider = '<script src="'. $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'ABOUT-US':
		$currentPage = __DIR__ . '/pages/other/about-page.php';
		$htmlTitle = 'About Us - Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'OUR-SERVICES':
		$currentPage = __DIR__ . '/pages/other/ourservices-page.php';
		$htmlTitle = 'Our Services - Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'RETURN-AND-EXCHANGE-POLICY':
		$currentPage = __DIR__ . '/pages/other/return-and-exchange-policy-page.php';
		$htmlTitle = 'Return and Exchange Policy - Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'COOKIES-POLICY':
		$currentPage = __DIR__ . '/pages/other/cookies-policy-page.php';
		$htmlTitle = 'Cookies Policy - Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	case 'CONTACT-US':
		$currentPage = __DIR__ . '/pages/other/contact-page.php';
		$htmlTitle = 'Contact Us - Musical Instruments';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
	default:
		$currentPage = __DIR__ . '/pages/filenotfound/filenotfound-page.php';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		$scriptKeenSlider = '<script src="' . $pathURL . '/assets/scripts/keen-slider/keen-option-submenu.js"></script>';
		break;
}

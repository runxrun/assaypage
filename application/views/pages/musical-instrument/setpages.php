<?php

switch (strtoupper($segment[1])) {
	case '':
		$currentPage = __DIR__ . '/pages/homepage/home-page.php';
		break;
	case 'CATEGORY':
		$currentPage = __DIR__ . '/pages/result/result-page.php';
		break;
	case 'PRODUCT':
		$currentPage = __DIR__ . '/pages/description/description-page.php';
		break;
	default:
		echo '404';
		break;
}

<?php
session_start();
// $expires=120;
// header( "Expires: ".gmdate("D, d M Y H:i:s", time()+$expires)."GMT");
// require_once("config/ConnectDB.php");
// require_once("func/funcContent.php");

$pathData = $_SERVER['REQUEST_URI'];

// if (empty($_SERVER['PATH_INFO'])) {
//   $pathData = $_SERVER['PATH_INFO'];
// }

// if($_SERVER["HTTPS"]=="on")
// {
// 	$scheme = "https://";
// }
// else
// {
// 	$scheme = "http://";
// }
// $pathhost=$scheme.$_SERVER["HTTP_HOST"];
// $sitename='https://www.11infotech.com';

// if(empty($pathData)){$pathData=$_SERVER['REQUEST_URI'];}

$segment = isset($pathData) ? explode('/', preg_replace('~^/?(.*?)/?$~', '$1', $pathData)) : array();
// $_dataLvl=0;
// $chkSegment=strtoupper($segment[$_dataLvl]);
// echo $segment[0];

if (strtoupper($segment[0]) === 'MICROSITES') {
  require_once("application/views/pages/microsites/microsites-page.php");
  return;
}

if (strtoupper($segment[0]) === 'MUSICAL-INSTRUMENT') {
  $pathURL = '/application/views/pages/musical-instrument/';
  require_once("application/views/pages/musical-instrument/template.php");
  return;
}

require_once("application/views/template.php");

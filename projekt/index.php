<?php

$title = 'Weather Forecast';
$description = 'Stay updated with the latest weather news and forecasts.';
$keywords = 'weather, forecast, news, meteorology, weather updates';

include 'meta.php';
include 'header.php';

switch ($_GET['menu']) {
    case 'home': include("pages/home.php"); break;
    case 'news': include("pages/news.php"); break;
    case 'contact': include("pages/contact.php"); break;
    case 'about': include("pages/about.php"); break;
    case 'gallery': include("pages/gallery.php"); break;
    default: include("pages/home.php"); break;
}

include 'footer.php';
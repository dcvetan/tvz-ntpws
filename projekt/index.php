<?php

session_start();
$db = mysqli_connect("localhost", "root", "", "ntpws") or die('Error connecting to MySQL server.');

$title = 'Weather Forecast';
$description = 'Stay updated with the latest weather news and forecasts.';
$keywords = 'weather, forecast, news, meteorology, weather updates';

include 'meta.php';
include 'header.php';

if (isset($_SESSION['user_id'])) {
    // Redirect logged-in users away
    if ($_GET['menu'] == 'login' || $_GET['menu'] == 'register') {
        header('Location: index.php?menu=home');
        exit();
    }
} else {
    // Redirect non-logged-in users away
    if ($_GET['menu'] == 'logout' || $_GET['menu'] == 'cms') {
        header('Location: index.php?menu=home');
        exit();
    }
}

switch ($_GET['menu']) {
    case 'home': include("pages/home.php"); break;
    case 'news': include("pages/news.php"); break;
    case 'article': include("pages/article.php"); break;
    case 'contact': include("pages/contact.php"); break;
    case 'about': include("pages/about.php"); break;
    case 'gallery': include("pages/gallery.php"); break;
    case 'login': include("pages/login.php"); break;
    case 'register': include("pages/register.php"); break;
    case 'logout': include("logout.php"); break;
    case 'cms': include("pages/cms.php"); break;
    default: include("pages/home.php"); break;
}

include 'footer.php';
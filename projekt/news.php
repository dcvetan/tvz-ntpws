<!DOCTYPE HTML>
<html>
<head>
    <title>News</title>
    <meta name="description" content="Latest weather news and updates.">
    <meta name="keywords" content="weather, news, updates, meteorology">
    <meta name="author" content="Dominik Cvetan">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="clouds-image"></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Gallery</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Latest Weather News</h1>
        <article>
            <img src="img/articles/earthquake.jpg" alt="ESMC earchquake Croatia">
            <div>
                <h2><a href="#">Novi jaki potres kod Siska: 'Ovo se osjetilo, pomaknulo je auto'</a></h2>
                <p>U subotu je blizu Siska zabilježen potres magnitude 2.5, javlja EMSC. Potres se dogodio 30. studenog u 17:08. <a href="#">Read more...</a></p>
                <p class="published-date">Published on: 2024-12-01</p>
            </div>
        </article>
        <article>
            <img src="img/articles/plitvice.jpg" alt="Plitvice zimi">
            <div>
                <h2><a href="#">Kakvo nas vrijeme čeka ovog vikenda?</a></h2>
                <p>U petak će biti umjereno do pretežno oblačno, i hladnije nego jučer. <a href="#">Read more...</a></p>
                <p class="published-date">Published on: 2024-12-01</p>
            </div>
        </article>
    </main>
    <footer>
        <p>Copyright © <?php echo date("Y");?> Dominik Cvetan</p>
        <div class="social-links">
            <a href="https://github.com/dcvetan" target="_blank">
                <img src="img/github-icon.png" alt="GitHub">
            </a>
            <a href="https://facebook.com" target="_blank">
                <img src="img/facebook-icon.png" alt="Facebook">
            </a>
            <a href="https://twitter.com" target="_blank">
                <img src="img/twitter-icon.png" alt="Twitter">
            </a>
        </div>
    </footer>
</body>
</html>
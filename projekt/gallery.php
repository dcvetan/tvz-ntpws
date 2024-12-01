<script>
    function updateArticle(imageId) {
        const title = document.getElementById('articleTitle');
        const content = document.getElementById('articleContent');
        const date = document.getElementById('articleDate');
        const currentDate = '2024-12-01';

        if (imageId === 1) {
            title.textContent = "Novi jaki potres kod Siska: 'Ovo se osjetilo, pomaknulo je auto'";
            content.innerHTML = `
                <p>U subotu je blizu Siska zabilježen potres magnitude 2.5, javlja EMSC. Potres se dogodio 30. studenog u 17:08.</p>
                <p>Čitatelj iz Siska javio nam je da se dobro osjetilo: “Dobro se osjetilo, baš jako. Dijete je ostavilo na terasi auto, pomaknuo se za pola metra”, rekao je i dodao da srećom nije bilo štete.</p>
                <p>Prema EMSC-u, epicentar potresa je bio 11 kilometara zapadno-sjeverozapadno od Siska na dubini od 9 kilometara.</p>
                <p>Podsjećamo, Hrvatsku su posljednjih godina pogodili mnogi potresi, a najjači su bili 2020. godine kad je porušen veliki dio centra Zagreba.</p>
                <p>Posebno su stradali Petrinja, Sisak i okolica.</p>
            `;
        } else {
            title.textContent = "Kakvo nas vrijeme čeka ovog vikenda?";
            content.innerHTML = `
                <p>U petak će biti umjereno do pretežno oblačno, i hladnije nego jučer.</p>
                <p>Maksimalna dnevna temperatura ide do 8°C. Moguća je i kiša u poslijepodnevnim satima, a ponegdje i pokoja pahulja.</p>
                <p>Tijekom vikenda se nastavlja oblačno vrijeme. Na kopnu umjereno i pretežno oblačno.</p>
                <p>Na Jadranu većinom sunčano. Vjetrovito i hladnije.</p>
                <p>Najniža temperatura od 0 do 5, na obali i otocima između 5 i 9 °C. Najviša dnevna uglavnom od 7 do 12, ponegdje i niža</p>
            `;
        }
        date.textContent = `Published: ${currentDate}`;
    }
</script>

<!DOCTYPE HTML>
<html>
<head>
    <title>Weather Gallery</title>
    <meta name="description" content="Weather photo gallery">
    <meta name="keywords" content="weather, gallery, photos">
    <meta name="author" content="Dominik Cvetan">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="clouds-image"></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="#">Gallery</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Weather Gallery</h1>
        <div class="gallery">
            <figure onclick="updateArticle(1)">
                <img src="img/articles/earthquake.jpg" alt="ESMC earchquake Croatia">
                <figcaption>Novi jaki potres kod Siska: 'Ovo se osjetilo, pomaknulo je auto'</figcaption>
            </figure>
            <figure onclick="updateArticle(2)">
                <img src="img/articles/plitvice.jpg" alt="Plitvice zimi">
                <figcaption>Kakvo nas vrijeme čeka ovog vikenda?</figcaption>
            </figure>
        </div>

        <article id="weatherArticle">
            <div class="article-left">
                <h2 id="articleTitle">Click an image to learn more</h2>
                <p id="articleDate"></p>
            </div>
            <div class="article-right">
                <div id="articleContent">
                    <p>Select one of the images above to view detailed information.</p>
                </div>
                <a href="index.php">Back to Home</a>
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
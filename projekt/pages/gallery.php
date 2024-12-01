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

<?php
print '
<main>
    <h1>Weather Gallery</h1>
    <div class="gallery">
        <figure onclick="updateArticle(1)">
            <img src="img/articles/earthquake.jpg" alt="ESMC earchquake Croatia">
            <figcaption>Novi jaki potres kod Siska: \'Ovo se osjetilo, pomaknulo je auto\'</figcaption>
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
</main>';
?>
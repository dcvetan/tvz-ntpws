<?php
$query = "SELECT n.*, pp.path as image_path 
          FROM news n 
          LEFT JOIN picture_paths pp ON n.id = pp.news_id 
          WHERE n.is_approved = 1 
            AND pp.is_main = 1 
            AND n.is_archived = 0 
          ORDER BY n.last_modified DESC";
$result = mysqli_query($db, $query);

$articles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'content' => nl2br(str_replace('\\n', "\n", $row['content'])),
        'date' => $row['last_modified'],
        'image' => $row['image_path']
    ];
}
?>

<script>
const articles = <?php echo json_encode($articles); ?>;

function updateArticle(articleId) {
    const article = articles.find(a => a.id === articleId.toString());
    if (!article) return;

    document.getElementById('articleTitle').textContent = article.title;
    document.getElementById('articleContent').innerHTML = article.content;
    document.getElementById('articleDate').textContent = 
        `Published: ${new Date(article.date).toLocaleDateString()}`;
}
</script>

<main>
    <h1>Weather Gallery</h1>
    <div class="gallery">
        <?php foreach ($articles as $article): ?>
        <figure onclick="updateArticle(<?php echo $article['id']; ?>)">
            <img src="<?php echo htmlspecialchars($article['image']); ?>" 
                 alt="<?php echo htmlspecialchars($article['title']); ?>">
            <figcaption><?php echo htmlspecialchars($article['title']); ?></figcaption>
        </figure>
        <?php endforeach; ?>
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
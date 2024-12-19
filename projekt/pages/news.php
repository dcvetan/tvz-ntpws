<?php
$query = "SELECT n.*, pp.path as image_path 
          FROM news n 
          LEFT JOIN picture_paths pp ON n.id = pp.news_id 
          WHERE n.is_approved = 1 
            AND pp.is_main = 1 
            AND n.is_archived = 0 
          ORDER BY n.last_modified DESC";
$result = mysqli_query($db, $query);

print '<main>
    <h1>Latest Weather News</h1>';

while ($article = mysqli_fetch_assoc($result)) {
    print '
    <article>
        <img src="' . htmlspecialchars($article['image_path']) . '" alt="' . htmlspecialchars($article['title']) . '">
        <div>
            <h2><a href="index.php?menu=article&id=' . $article['id'] . '">' . htmlspecialchars($article['title']) . '</a></h2>
            <p>' . substr(str_replace('\\n', "\n", htmlspecialchars($article['content'])), 0, 200) . '... <a href="index.php?menu=article&id=' . $article['id'] . '">Read more...</a></p>
            <p class="published-date">Published on: ' . date('Y-m-d', strtotime($article['last_modified'])) . '</p>
        </div>
    </article>';
}

print '</main>';
?>
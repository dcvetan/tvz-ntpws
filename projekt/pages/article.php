<?php
if (!isset($_GET['id'])) {
    header('Location: index.php?menu=news');
    exit();
}

$articleId = mysqli_real_escape_string($db, $_GET['id']);

$query = "SELECT n.*, pp.path as main_image, u.firstname, u.lastname 
          FROM news n 
          LEFT JOIN picture_paths pp ON n.id = pp.news_id AND pp.is_main = 1
          LEFT JOIN users u ON n.user_id = u.id 
          WHERE n.id = ? AND n.is_approved = 1 AND n.is_archived = 0";

$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $articleId);
mysqli_stmt_execute($stmt);
$article = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$article) {
    header('Location: index.php?menu=news');
    exit();
}

$query = "SELECT path FROM picture_paths 
          WHERE news_id = ? AND is_main = 0 
          ORDER BY id";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $articleId);
mysqli_stmt_execute($stmt);
$additionalImages = mysqli_stmt_get_result($stmt);
?>

<main>
    <article class="article-detail">
        <div class="article-header-container">
            <div class="article-header">
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                
                <div class="article-meta">
                    <span>
                        <i class="fas fa-user"></i>
                        <?php echo htmlspecialchars($article['firstname'] . ' ' . $article['lastname']); ?>
                    </span>
                    <span>
                        <i class="fas fa-calendar"></i>
                        <?php echo date('F j, Y', strtotime($article['last_modified'])); ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if ($article['main_image']): ?>
            <div class="main-image">
                <img src="<?php echo htmlspecialchars($article['main_image']); ?>" 
                     alt="<?php echo htmlspecialchars($article['title']); ?>">
            </div>
        <?php endif; ?>

        <div class="article-body">
            <div class="article-content">
            <?php 
            $content = nl2br(str_replace('\\n', "\n", htmlspecialchars($article['content'])));
            echo $content;
            ?>
            </div>

            <?php if (mysqli_num_rows($additionalImages) > 0): ?>
            <div class="article-gallery">
                <h2>Photo Gallery</h2>
                <div class="image-grid">
                    <?php while ($img = mysqli_fetch_assoc($additionalImages)): ?>
                        <img src="<?php echo htmlspecialchars($img['path']); ?>" 
                             alt="Additional image">
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <a href="index.php?menu=news" class="back-button">← Back to News</a>
    </article>
</main>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'updateuser' || ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']))) {
    if ($_SESSION['role'] != 'admin') {
        $_SESSION['error'] = "Only administrators can update users";
        header('Location: index.php?menu=cms');
        exit();
    }

    $userId = mysqli_real_escape_string($db, $_POST['user_id']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $role = mysqli_real_escape_string($db, $_POST['role']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);

    $query = "SELECT id FROM users WHERE username = ? AND id != ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "si", $username, $userId);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_fetch($stmt)) {
        $_SESSION['error'] = "Username already exists";
        header('Location: index.php?menu=cms&action=edituser&id=' . $userId);
        exit();
    }

    $query = "UPDATE users SET 
              username = ?,
              email = ?,
              role = ?,
              firstname = ?,
              lastname = ?
              WHERE id = ?";
    
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $username, $email, $role, $firstname, $lastname, $userId);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "User updated successfully";
    } else {
        $_SESSION['error'] = "Error updating user: " . mysqli_error($db);
    }
    
    header('Location: index.php?menu=cms');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'approve' && isset($_GET['id'])) {
    $newsId = mysqli_real_escape_string($db, $_GET['id']);
    
    if ($_SESSION['role'] == 'admin') {
        $query = "UPDATE news SET is_approved = NOT is_approved WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $newsId);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Article approval status updated";
        } else {
            $_SESSION['error'] = "Error updating approval status";
        }
    } else {
        $_SESSION['error'] = "Only administrators can approve articles";
    }
    
    header('Location: index.php?menu=cms');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $newsId = mysqli_real_escape_string($db, $_GET['id']);

    $query = "SELECT path FROM picture_paths WHERE news_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $newsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Delete physical image files
    while ($row = mysqli_fetch_assoc($result)) {
        if (file_exists($row['path'])) {
            unlink($row['path']);
        }
    }

    $query = "SELECT user_id FROM news WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $newsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $article = mysqli_fetch_assoc($result);

    if ($_SESSION['role'] == 'admin' || $article['user_id'] == $_SESSION['user_id']) {
        $query = "DELETE pp, n FROM news n 
        LEFT JOIN picture_paths pp ON n.id = pp.news_id 
        WHERE n.id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $newsId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "News article deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting news article";
        }
    } else {
        $_SESSION['error'] = "You don't have permission to delete this article";
        header('Location: index.php?menu=cms');
        exit();
    }
    
    header('Location: index.php?menu=cms');
    exit();
} else if (isset($_GET['action']) && $_GET['action'] == 'archive' && isset($_GET['id'])) {
    $newsId = mysqli_real_escape_string($db, $_GET['id']);

    $query = "UPDATE news SET is_archived = NOT is_archived 
              WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $newsId);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Article archive status updated";
    } else {
        $_SESSION['error'] = "Error updating archive status";
    }
    
    header('Location: index.php?menu=cms');
    exit();
} else if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $newsId = mysqli_real_escape_string($db, $_GET['id']);
    
    $query = "SELECT * FROM news WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $newsId);
    mysqli_stmt_execute($stmt);
    $editArticle = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    $query = "SELECT * FROM picture_paths WHERE news_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $newsId);
    mysqli_stmt_execute($stmt);
    $editImages = mysqli_stmt_get_result($stmt);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_id'])) {
        $editId = mysqli_real_escape_string($db, $_POST['edit_id']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $content = mysqli_real_escape_string($db, $_POST['content']);
        
        $query = "UPDATE news SET title = ?, content = ? WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $editId);
        
        if (mysqli_stmt_execute($stmt)) {
            // Handle new image uploads for edit
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = 'uploads/news/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $fileName = time() . '_' . $_FILES['images']['name'][$key];
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $isMain = ($key == 0) ? 1 : 0;
                        $query = "INSERT INTO picture_paths (news_id, path, is_main) VALUES (?, ?, ?)";
                        $stmt = mysqli_prepare($db, $query);
                        mysqli_stmt_bind_param($stmt, "isi", $editId, $filePath, $isMain);
                        mysqli_stmt_execute($stmt);
                    }
                }
            }
            $_SESSION['success'] = "Article updated successfully";
        } else {
            $_SESSION['error'] = "Error updating article";
        }
        header('Location: index.php?menu=cms');
        exit();
    } else {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $content = mysqli_real_escape_string($db, $_POST['content']);
        $userId = $_SESSION['user_id'];

        $query = "INSERT INTO news (title, content, user_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            $newsId = mysqli_insert_id($db);
            
            // Handle multiple image uploads
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = 'uploads/news/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $fileName = time() . '_' . $_FILES['images']['name'][$key];
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $isMain = ($key == 0) ? 1 : 0; // First image is main
                        $query = "INSERT INTO picture_paths (news_id, path, is_main) VALUES (?, ?, ?)";
                        $stmt = mysqli_prepare($db, $query);
                        mysqli_stmt_bind_param($stmt, "isi", $newsId, $filePath, $isMain);
                        mysqli_stmt_execute($stmt);
                    }
                }
            }
            $_SESSION['success'] = "News submitted for approval";
        } else {
            $_SESSION['error'] = "Error submitting news";
        }
        header('Location: index.php?menu=cms');
        exit();
    }
}

// Fetch existing news
if (isset($_SESSION['role']) && $_SESSION['role'] == 'editor' || $_SESSION['role'] == 'admin') {
    $query = "SELECT n.*, COUNT(pp.id) as image_count, u.firstname, u.lastname 
              FROM news n 
              LEFT JOIN picture_paths pp ON n.id = pp.news_id 
              LEFT JOIN users u ON n.user_id = u.id 
              GROUP BY n.id 
              ORDER BY n.is_archived ASC, n.last_modified DESC";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_execute($stmt);
} else {
    $query = "SELECT n.*, COUNT(pp.id) as image_count 
              FROM news n 
              LEFT JOIN picture_paths pp ON n.id = pp.news_id 
              WHERE n.user_id = ? 
              GROUP BY n.id 
              ORDER BY n.is_archived ASC, n.last_modified DESC";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
}
$result = mysqli_stmt_get_result($stmt);
?>

<main>
    <div class="cms-container">
    <?php if (isset($editArticle)): ?>
        <div class="cms-form-container">
            <h2>Edit News Article</h2>
            <form action="" method="post" enctype="multipart/form-data" class="cms-form">
                <input type="hidden" name="edit_id" value="<?php echo $editArticle['id']; ?>">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($editArticle['title']); ?>">
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($editArticle['content']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Current Images:</label>
                    <div class="current-images">
                        <?php while ($img = mysqli_fetch_assoc($editImages)): ?>
                            <div class="image-preview">
                                <img src="<?php echo $img['path']; ?>" alt="Article image" style="max-width: 100px;">
                                <?php if ($img['is_main']): ?>
                                    <span class="main-image-badge">Main Image</span>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="images">Add More Images:</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>
                </div>
                <div class="form-actions">
                    <button type="submit">Update Article</button>
                    <a href="index.php?menu=cms" class="cancel-button">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="cms-form-container">
            <h2>Submit News Article</h2>
            <form action="" method="post" enctype="multipart/form-data" class="cms-form">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label for="images">Images (First image will be main):</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>
                </div>
                <button type="submit">Submit News</button>
            </form>
        </div>
    <?php endif; ?>
        

    <div class="cms-news-list">
        <h2><?php echo (isset($_SESSION['role']) && $_SESSION['role'] == 'editor') ? 'Manage News Articles' : 'Your News Articles'; ?></h2>
        <table class="news-table">
            <thead>
            <tr>
                <th>Title</th>
                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'editor' || $_SESSION['role'] == 'admin')): ?>
                    <th>Author</th>
                <?php endif; ?>
                <th>Date</th>
                <th>Status</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="<?php echo $row['is_archived'] ? 'archived' : ''; ?>">
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'editor' || $_SESSION['role'] == 'admin'): ?>
                            <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                        <?php endif; ?>
                        <td><?php echo date('Y-m-d', strtotime($row['last_modified'])); ?></td>
                        <td><?php echo $row['is_approved'] ? 'Approved' : 'Pending'; ?></td>
                        <td><?php echo $row['image_count']; ?></td>
                        <td>
                            <a href="index.php?menu=cms&action=edit&id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="index.php?menu=cms&action=archive&id=<?php echo $row['id']; ?>" 
                            class="<?php echo $row['is_archived'] ? 'unarchive' : 'archive'; ?>">
                                <?php echo $row['is_archived'] ? 'Unarchive' : 'Archive'; ?>
                            </a>
                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                <a href="index.php?menu=cms&action=approve&id=<?php echo $row['id']; ?>"
                                class="<?php echo $row['is_approved'] ? 'unapprove' : 'approve'; ?>">
                                    <?php echo $row['is_approved'] ? 'Unapprove' : 'Approve'; ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($_SESSION['role'] == 'admin' || $row['user_id'] == $_SESSION['user_id']): ?>
                                <a href="index.php?menu=cms&action=delete&id=<?php echo $row['id']; ?>" 
                                onclick="return confirm('Are you sure you want to delete this article?')"
                                class="delete">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add after news table div -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <div class="cms-users-list">
            <h2>Manage Users</h2>
            <table class="news-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT u.*, c.name as country_name 
                            FROM users u 
                            LEFT JOIN countries c ON u.country_id = c.id 
                            ORDER BY u.username";
                    $usersResult = mysqli_query($db, $query);
                    while ($user = mysqli_fetch_assoc($usersResult)):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['city']); ?></td>
                            <td><?php echo htmlspecialchars($user['country_name']); ?></td>
                            <td>
                                <a href="index.php?menu=cms&action=edituser&id=<?php echo $user['id']; ?>" 
                                class="edit">Edit</a>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <a href="index.php?menu=cms&action=deleteuser&id=<?php echo $user['id']; ?>" 
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="delete">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if (isset($_GET['action']) && $_GET['action'] == 'edituser' && isset($_GET['id'])): 
                $userId = mysqli_real_escape_string($db, $_GET['id']);
                $query = "SELECT * FROM users WHERE id = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);
                $editUser = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
            ?>
                <div class="cms-form-container">
                    <h2>Edit User</h2>
                    <form action="index.php?menu=cms&action=updateuser" action="" method="post" class="cms-form">
                        <input type="hidden" name="user_id" value="<?php echo $editUser['id']; ?>">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($editUser['username']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($editUser['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select id="role" name="role" required>
                                <option value="user" <?php echo $editUser['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="editor" <?php echo $editUser['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
                                <option value="admin" <?php echo $editUser['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($editUser['firstname']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($editUser['lastname']); ?>" required>
                        </div>
                        <div class="form-actions">
                            <button type="submit">Update User</button>
                            <a href="index.php?menu=cms" class="cancel-button">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</main>
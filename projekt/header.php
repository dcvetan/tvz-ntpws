<?php
print '
<body>
    <header>
        <div class="clouds-image"></div>
        <nav>
            <ul>
                <li><a href="index.php?menu=home">Home</a></li>
                <li><a href="index.php?menu=news">News</a></li>
                <li><a href="index.php?menu=contact">Contact</a></li>
                <li><a href="index.php?menu=about">About</a></li>
                <li><a href="index.php?menu=gallery">Gallery</a></li>';

if (!isset($_SESSION['user_id'])) {
    print '
                <li><a href="index.php?menu=login">Login</a></li>
                <li><a href="index.php?menu=register">Register</a></li>';
} else {
    print '
                <li><a href="index.php?menu=logout">Logout</a></li>';
}

print '
            </ul>
        </nav>
    </header>';
?>
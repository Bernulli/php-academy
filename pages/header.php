<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/indexstyle.css">
    <title>Document</title>
</head>
<body>
<div class="wrapper">
    <header class="main-header">
        <nav class="main-navigation">
            <div class="main-navigation-wrapper">
                <div class="container">
                    <ul class="site-navigation">
                        <li><a href="main.php">Головна</a></li>
                            <li><a href="blog.php">Блог</a></li>
                        <li><a href="info.php">Інформація</a></li>
                    </ul>
                    <ul class="user-navigation">
                        <?php if(!isset($_SESSION['user'])) :?>
                            <li><a class="login login-link" href="login.php">Вхід</a></li>
                        <?php else :?>
                            <li class="hello"><?php echo 'Вітаємо, ' . $_SESSION['user'] . '<br>';?></li>
                            <li><a class="log_out login-link" href="logout.php">Вихід</a></li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
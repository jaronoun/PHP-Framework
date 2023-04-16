<?php
require __DIR__.'/../../../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<!--    <link rel="stylesheet" type="text/css" href= '../../../public/css/style.css'>-->
    <link rel="stylesheet" type="text/css" href= '/css/style.css'>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand">Isoros</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($loggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/cijfers"><?php echo $page == 'grades' ? '<b>Cijfers</b>' : 'Cijfers'; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/tentamens"><?php echo $page == 'exams' ? '<b>Tentamens</b>' : 'Tentamens'; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profiel"><?php echo $page == 'users' ? '<b>Profiel</b>' : 'Profiel'; ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if ($loggedIn): ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/logout">Log Out</a></li>
                    </ul>
                <?php else: ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/login">Log In</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<main>
<div class="container">
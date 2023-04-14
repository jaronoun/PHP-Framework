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
    <link rel="stylesheet" type="text/css" href= '/css/style.css'>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="/home">Isoros</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($loggedIn): ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="/cijfers">Cijfers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tentamens">Tentamens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profiel">Profiel</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/login">Log Out</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/login">Log In</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
        </div>
    </nav>
</header>
<main>
<div class="container">
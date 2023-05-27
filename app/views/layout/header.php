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

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">Isoros</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            {% if login %} test {% endif %}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/cijfers"><b>Cijfers</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tentamens"><b>Tentamens</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profiel"><b>Profiel</b></a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/logout">Log Out</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/login">Log In</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="container">
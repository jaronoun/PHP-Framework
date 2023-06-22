<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href= '/css/style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">Isoros</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {% if loggedIn %}
                <li class="nav-item">
                    <a class="nav-link" href="/cijfers">Cijfers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tentamens">Tentamens</a>
                </li>
                {% endif %}
                {% if role == teacher %}
                <li class="nav-item">
                    <a class="nav-link" href="/beoordeling">Beoordeling</a>
                </li>
                {% endif %}
                {% if loggedIn %}
                <li class="nav-item">
                    <a class="nav-link" href="/profiel">Profiel</a>
                </li>
                {% endif %}
            </ul>
            {% if loggedIn %}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/logout">Log Out</a></li>
            </ul>
            {% else %}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/login">Log In</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            </ul>
            {% endif %}
        </div>
    </div>
</nav>


<main>
        <div class="container mt-5">
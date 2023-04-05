<?php
require __DIR__.'/../../../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <title>Home Page</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-bwGRhYgEKu+l7VrlFlE3Mq7pGmi+jtcBmGNVZjzTPhT+CJBBEzOHbK7p/1zTCX9N" crossorigin="anonymous" media="screen" >

    <!-- JavaScript en popper.js (nodig voor sommige Bootstrap-functies) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-78S+1JpO1M+O4ovMv4Qo4sZLx1/35lWNb/TrA2rCmFKy/lXzNcL6GStfntChuwN1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js" integrity="sha512-BqC0nl1vAvOcGah+H5I8PffW6UNvwn6l5B5tkxU8zyK52YrLwQrweoOyMnzO9zGvJvzH+I0b1Ox+GWRNn/mcrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">My Site</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>
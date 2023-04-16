<?php
// Include the necessary files for the view
require_once __DIR__.'/../../../vendor/autoload.php';
?>


<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">Mijn Profiel</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Naam: <?php echo $user->getName(); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Email: <?php echo $user->getEmail(); ?></h6>
                    <p class="card-text">Rol: <?php echo $user->getRole(); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


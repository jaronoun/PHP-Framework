<?php ?>

    <div class="row mt-3">
        <!-- Most recent result card -->
        <div class="col-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Meest recente resultaat</div>
                <div class="card-body">
                    <h1 class="display-1 text-center">85</h1>
                    <h2 class="text-center mb-4">Wiskunde</h2>
                    <p class="text-center mb-0">Examendatum: <?php echo $data; ?></p>
                </div>
            </div>
        </div>

        <!-- Uncompleted exams card -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card">
                <div class="card-header">Behaalde cijfers</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h5 class="mb-1">Wiskunde</h5>
                            <p class="mb-1">Behaald met een 8.5</p>
                            <small>2 maart 2023</small>
                        </li>
                        <li class="list-group-item">
                            <h5 class="mb-1">Nederlands</h5>
                            <p class="mb-1">Behaald met een 7.8</p>
                            <small>14 februari 2023</small>
                        </li>
                        <li class="list-group-item">
                            <h5 class="mb-1">Engels</h5>
                            <p class="mb-1">Behaald met een 9.0</p>
                            <small>18 januari 2023</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php

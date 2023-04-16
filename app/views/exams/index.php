<?php?>
<h1 class="text-center mb-4">Tentamen Inschrijving</h1>
<div class="row">
    <!-- Search Exams Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Zoek Tentamen</div>
            <div class="card-body">
                <form action="#" method="get">
                    <div class="form-group">
                        <label for="exam-name">Tentamen Naam</label>
                        <input type="text" class="form-control" id="exam-name" name="exam-name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Inschrijven</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Enrolled Exams Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header ">Ingeschreven Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Exam 1 <button class="btn btn-danger btn-sm float-right">Uitschrijven</button></li>
                    <li class="list-group-item">Exam 2 <button class="btn btn-danger btn-sm float-right">Uitschrijven</button></li>
                    <li class="list-group-item">Exam 3 <button class="btn btn-danger btn-sm float-right">Uitschrijven</button></li>
                </ul>
            </div>
        </div>
    </div>
</div>

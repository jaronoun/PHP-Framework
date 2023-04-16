<?php?>
<h1 class="text-center mb-4">Tentamen Inschrijving</h1>
<div class="row">
    <!-- Search Exams Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">Zoek Tentamen</div>
            <div class="card-body">
                <form action="#" method="get">
                    <div class="form-group">
                        <label for="exam-name">Exam Name</label>
                        <input type="text" class="form-control" id="exam-name" name="exam-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Enrolled Exams Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">Ingeschreven Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Exam 1 <button class="btn btn-danger btn-sm float-right">Unenroll</button></li>
                    <li class="list-group-item">Exam 2 <button class="btn btn-danger btn-sm float-right">Unenroll</button></li>
                    <li class="list-group-item">Exam 3 <button class="btn btn-danger btn-sm float-right">Unenroll</button></li>
                </ul>
            </div>
        </div>
    </div>
</div>

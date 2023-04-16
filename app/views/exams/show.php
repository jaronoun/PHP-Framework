<? php ?>
<div class="row">
    <!-- Search Exams Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Zoek Tentamen</div>
            <div class="card-body">
                <form action="/tentamens" method="post">
                        <div class="form-group">
                            <label for="exam-name">Tentamen Naam</label>
                            <div class="row">
                            <div class="col-8">
                                <input type="text" class="form-control" id="exam-name" name="exam-name"
                                       placeholder="Zoek op tentamen naam" required>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-success">Zoeken</button>
                            </div>
                        </div>
                    </div>
                </form>

                    <div class="row">
                        <div class="col-8">
                            <div class="container">
                                <p><u><?php echo $exam->getName(); ?></u></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-success">Inschrijven</button>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- Enrolled Exams Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header ">Ingeschreven Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Exam 1
                        <button class="btn btn-danger btn-sm float-right">Uitschrijven</button>
                    </li>
                    <li class="list-group-item">Exam 2
                        <button class="btn btn-danger btn-sm float-right">Uitschrijven</button>
                    </li>
                    <li class="list-group-item">Exam 3
                        <button class="btn btn-danger btn-sm float-right">Uitschrijven</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Completed exams card -->
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header">Opkomende examens</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5>Wiskunde</h5>
                        <p>10 mei 2023</p>
                        <p>Tijd: 10:00 - 12:00</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Nederlands</h5>
                        <p>15 mei 2023</p>
                        <p>Tijd: 14:00 - 16:00</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Geschiedenis</h5>
                        <p>20 mei 2023</p>
                        <p>Tijd: 9:00 - 11:00</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
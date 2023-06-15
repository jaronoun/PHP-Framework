{% extends layout/header.php %}
<div class="row">
    <!-- Search Exams Card -->
    {% if role == student %}
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Zoek Tentamen</div>
            <div class="card-body">
                <form action="/tentamens" method="post">
                    <div class="container">
                        <div class="form-group">
                            <label for="exam-name">Tentamen Naam</label>
                            <input type="text" class="form-control" id="exam-name" name="exam-name" placeholder="Zoek op tentamen naam" required>
                        </div>
                    </div>
                    <div class="container">
                        <button type="submit" class="btn btn-dark sml-btn">Inschrijven</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Enrolled Exams Card -->
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Ingeschreven Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Exam 1 <button class="btn btn-dark float-right sml-btn">Uitschrijven</button></li>
                    <li class="list-group-item">Exam 2 <button class="btn btn-dark sml-btn float-right">Uitschrijven</button></li>
                    <li class="list-group-item">Exam 3 <button class="btn btn-dark sml-btn float-right">Uitschrijven</button></li>
                </ul>
            </div>
        </div>
    </div>
    {% endif %}
    <!-- Grading Card -->
    {% if role == teacher %}
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Maak Tentamen</div>
            <div class="card-body">
                <!-- Create Exam Form -->
                <form action="/tentamens" method="post">
                    <div class="form-group mb-3">
                        <label for="name">Tentamen Naam</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Voer de tentamennaam in" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="desc">Beschrijving</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="Voer een beschrijving in"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="start-time">Start Datum/Tijd</label>
                        <input type="datetime-local" class="form-control" id="start-time" name="start-time" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="end-time">Eind Datum/Tijd</label>
                        <input type="datetime-local" class="form-control" id="end-time" name="end-time" required>
                    </div>

                    <button type="submit" class="btn btn-dark sml-btn">Tentamen Aanmaken</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Exam 1 <button class="btn btn-dark float-right sml-btn">Uitschrijven</button></li>
                    <li class="list-group-item">Exam 2 <button class="btn btn-dark sml-btn float-right">Uitschrijven</button></li>
                    <li class="list-group-item">Exam 3 <button class="btn btn-dark sml-btn float-right">Uitschrijven</button></li>
                </ul>
            </div>
        </div>
    </div>
    {% endif %}
    <!-- Completed exams card -->
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Opkomende Tentamens</div>
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
{% extends layout/footer.php %}

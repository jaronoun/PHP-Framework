{% extends layout/header.php %}
<div class="row">
    <!-- Search Exams Card -->
    {% if user.role == 'student' %}
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Zoek Tentamen</div>
            <div class="card-body">
                <form action="/tentamens" method="post">
                    <div class="container">
                        <div class="form-group">
                            <label for="exam-name">Filter</label>
                            <input type="text" class="form-control" id="exam-name" name="exam-name" placeholder="Zoek op tentamen ID, naam of datum" required>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-white bg-dark">ID</th>
                        <th class="text-white bg-dark">Naam</th>
                        <th class="text-white bg-dark">Start</th>
                        <th class="text-white bg-dark">Acties</th>
                    </tr>
                    </thead>
                    <tbody id="exams">
                    {% for exam in exams %}
                    {% if isNotEnrolled(exam.id) %}
                    <tr>
                        <td>{{ exam.id }}</td>
                        <td>{{ exam.name }}</td>
                        <td>{{ getDate(exam.start_time) }}</td>
                        <td><a href="/tentamens/enroll/{{ exam.id }}" class="btn btn-dark sml-btn">Inschrijven</a></td>
                    </tr>
                    {% endif %}
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Enrolled Exams Card -->
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Ingeschreven Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-white bg-dark">Naam</th>
                            <th class="text-white bg-dark">Acties</th>
                        </tr>
                        </thead>
                        <tbody id="examUser">
                        {% for exam in examUser %}
                        <tr>
                            <td>{{ exam.name }}</td>
                            {% if getUserGrade(exam.id) %}
                            <td><a class="btn btn-dark sml-btn disabled">Behaald</a></td>
                            {% else %}
                            <td><a href="/tentamens/unEnroll/{{ exam.id }}" class="btn btn-dark sml-btn">Uitschrijven</a></td>
                            {% endif %}
                        </tr>
                        {% endfor %}
                </ul>
            </div>
        </div>
    </div>
    {% endif %}
    <!-- Grading Card -->
    {% if user.role == 'teacher' %}
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
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-white bg-dark">ID</th>
                        <th class="text-white bg-dark">Naam</th>
                        <th class="text-white bg-dark">Start</th>
                        <th class="text-white bg-dark">Acties</th>
                    </tr>
                    </thead>
                    <tbody id="exams">
                    {% for exam in exams %}
                    {% if isNotEnrolled(exam.id) %}
                    <tr>
                        <td>{{ exam.id }}</td>
                        <td>{{ exam.name }}</td>
                        <td>{{ getDate(exam.start_time) }}</td>
                        <td>
                            <a href="/tentamens/enroll/{{ exam.id }}" class="btn btn-dark sml-btn">Inschrijven</a>
                        </td>
                    </tr>
                    {% endif %}
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark"> Tentamens</div>
            <div class="card-body">
                <ul class="list-group">
                    {% for exam in examUser %}
                        <li class="list-group-item"> {{ exam.name }}
                            <a href="/tentamens/{{ exam.id }}" class="btn btn-dark float-right sml-btn{% if hasGrades(exam.id) %} disabled {% endif %}">Verwijderen</a>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark sml-btn" data-bs-toggle="modal" data-bs-target="#{{ exam.id }}Modal">
                                Edit
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="{{ exam.id }}Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-white bg-dark">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ exam.name }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/tentamens/{{ exam.id }}" method="post">
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="name">Tentamen Naam</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ exam.name }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="desc">Beschrijving</label>
                                                <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="{{ exam.desc }}"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="start-time">Start Datum/Tijd</label>
                                                <input type="datetime-local" class="form-control" id="start-time" name="start-time" value="{{ exam.start_time }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="end-time">Eind Datum/Tijd</label>
                                                <input type="datetime-local" class="form-control" id="end-time" name="end-time" value="{{ exam.end_time }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary sml-btn" data-bs-dismiss="modal">Sluiten</button>
                                            <button type="submit" class="btn btn-dark sml-btn">Opslaan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    {% endfor %}
                </ul>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Opkomende Tentamens</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    {% for exam in examUser %}
                        <li class="list-group-item">
                            <h5>{{ exam.name }}</h5>
                            <p>{{ getDate(exam.start_time) }}</p>
                            <p>
                                Start: {{ getTime(exam.start_time) }} </br>
                                Eind: {{ getTime(exam.end_time) }}
                            </p>
                        </li>
                    {% endfor %}
                </ul>
            </div>
        </div>
    </div>
    {% endif %}

    {% if user.role == 'admin' %}
    <div class="col-12 col-md-12 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Tentamens</div>
            <label for="exam-name">Filter</label>
            <input type="text" class="form-control" id="exam-name" name="exam-name" placeholder="Zoek op ID, naam of datum" required>
            <div class="table-responsive">
                <h3><u></u></h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="text-white bg-dark" scope="col">id</th>
                        <th class="text-white bg-dark" scope="col">Naam</th>
                        <th class="text-white bg-dark" scope="col">Beschrijving</th>
                        <th class="text-white bg-dark" scope="col">Start</th>
                        <th class="text-white bg-dark" scope="col">Einde</th>
                        <th class="text-white bg-dark" scope="col">Aangemaakt op:</th>
                        <th class="text-white bg-dark" scope="col">Gewijzigd op:</th>
                        <th class="text-white bg-dark">Akties</th>
                    </tr>
                    </thead>
                    <tbody id="exams">
                    {% for exam in allExams %}
                    <tr>
                        <th scope="row">{{ exam.id }}</th>
                        <td>{{ exam.name }}</td>
                        <td>{{ exam.desc }}</td>
                        <td>{{ exam.start_time }}</td>
                        <td>{{ exam.end_time }}</td>
                        <td>{{ exam.created_at }}</td>
                        <td>{{ exam.updated_at }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark sml-btn" data-bs-toggle="modal" data-bs-target="#{{ exam.id }}Modal">
                                Edit
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="{{ exam.id }}Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-white bg-dark">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ exam.name }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/tentamens/{{ exam.id }}" method="post">
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="name">Tentamen Naam</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ exam.name }}" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="desc">Beschrijving</label>
                                                    <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="{{ exam.desc }}"></textarea>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="start-time">Start Datum/Tijd</label>
                                                    <input type="datetime-local" class="form-control" id="start-time" name="start-time" value="{{ exam.start_time }}" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="end-time">Eind Datum/Tijd</label>
                                                    <input type="datetime-local" class="form-control" id="end-time" name="end-time" value="{{ exam.end_time }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary sml-btn" data-bs-dismiss="modal">Sluiten</button>
                                                <button type="submit" class="btn btn-dark sml-btn">Opslaan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="/tentamens/{{ exam.id }}" class="btn btn-dark float-right sml-btn {% if hasGrades(exam.id) %} disabled {% endif %}">Verwijderen</a>
                        </td>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-12 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Cijfers</div>
            <label for="grade-name">Filter</label>
            <input type="text" class="form-control" id="grade-name" name="grade-name" placeholder="Zoek op ID, tentamen naam, gebruikers naam, cijfer of datum" required>
            <div class="table-responsive">
                <h3><u></u></h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="text-white bg-dark" scope="col">id</th>
                        <th class="text-white bg-dark" scope="col">Tentamen</th>
                        <th class="text-white bg-dark" scope="col">Student</th>
                        <th class="text-white bg-dark" scope="col">Cijfer</th>
                        <th class="text-white bg-dark" scope="col">Docent</th>
                        <th class="text-white bg-dark" scope="col">Aangemaakt op:</th>
                        <th class="text-white bg-dark" scope="col">Gewijzigd op:</th>
                        <th class="text-white bg-dark">Akties</th>
                    </tr>
                    </thead>
                    <tbody id="grades">
                    {% for grade in allGrades %}
                    <tr>
                        <form action="/tentamens/cijfer/{{ grade.id }}" method="POST" enctype="application/x-www-form-urlencoded">
                            <th>{{ grade.id }}</th>
                            <td>{{ grade.exam_name }}</td>
                            <td>{{ grade.user_name }}</td>
                            <td><input type="number" name="grade" value="{{ grade.grade }}"></td>
                            <td>{{ grade.teacher_name }}</td>
                            <td>{{ grade.created_at }}</td>
                            <td>{{ grade.updated_at }}</td>
                            <td>
                                <button type="submit" class="btn btn-dark float-right sml-btn">Update</button>
                                <a href="/tentamens/cijfer/{{ grade.id }}" class="btn btn-dark float-right sml-btn">Verwijderen</a>
                            </td>
                        </form>
                    </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {% endif %}
</div>
<script>
    $(document).ready(function(){
        $("#exam-name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#exams tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $(document).ready(function(){
        $("#exam-name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#exams tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $(document).ready(function(){
        $("#grade-name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#grades tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
{% extends layout/footer.php %}


{% extends layout/header.php %}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-dark">Profiel</div>
            <div class="card-body">
                <h5 class="card-title">Name: {{ user.name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Email: {{ user.email }} </h6>
                <p class="card-text">Role: {{ user.role }}</p>
            </div>
        </div>
    </div>
</div>

{% if user.role == 'admin' %}
<div class="col-12 col-md-12 mb-3">
    <div class="card">
        <div class="card-header text-white bg-dark">Gebruikers</div>

        <br>
        <div class="card-header text-white bg-dark">
            <p class="text">Nieuw gebruiker</p>
        </div>

        <div class="card-body">
            <form action="/users" method="POST" enctype="application/x-www-form-urlencoded">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" id="role">
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark sml-btn">Registreer</button>
                </div>
            </form>
        </div>
        <br>
        <label for="user-name">Filter</label>
        <input type="text" class="form-control" id="user-name" name="user-name" placeholder="Zoek op ID, naam of email" required>

        <div class="table-responsive">
            <h3><u></u></h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-white bg-dark" scope="col">id</th>
                    <th class="text-white bg-dark" scope="col">Naam</th>
                    <th class="text-white bg-dark" scope="col">Email</th>
                    <th class="text-white bg-dark" scope="col">Rol</th>
                    <th class="text-white bg-dark" scope="col">Token</th>
                    <th class="text-white bg-dark" scope="col">Aangemaakt op:</th>
                    <th class="text-white bg-dark" scope="col">Gewijzigd op:</th>
                    <th class="text-white bg-dark">Akties</th>
                </tr>
                </thead>
                <tbody id="users">
                {% for user in allUsers %}
                <tr>
                    <th scope="row">{{ user.id }}</th>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role }}</td>
                    <td>{{ user.remember_token }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>{{ user.updated_at }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark sml-btn" data-bs-toggle="modal" data-bs-target="#{{ user.id }}Modal">
                            Edit
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="{{ user.id }}Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-white bg-dark">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ user.name }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/users/{{ user.id }}" method="post">
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="name">Naam</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ user.name }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{ user.email }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="role">Rol</label>
                                                <input type="text" class="form-control" id="role" name="role" value="{{ user.role }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="token">Token</label>
                                                <input type="text" class="form-control" id="token" name="token" value="{{ user.remember_token }}">
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
                        <a href="/users/{{ user.id }}" class="btn btn-dark float-right sml-btn">Verwijderen</a>
                    </td>
                </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-12 col-md-12 mb-3">
    <div class="card">
        <div class="card-header text-white bg-dark">Inschrijvingen</div>

        <div class="card-body">
            <form action="/users/enroll" method="post">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="tentamen">Tentamen</label>
                    <select class="form-select" id="tentamen" name="exam_id">
                        <option selected></option>
                        {% for exam in allExams %}
                        <option value="{{ exam.id }}">{{ exam.name }}</option>
                        {% endfor %}
                    </select>
                </div>

                <div class="form-group mb-3">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="students">Student</label>
                        <select class="form-select" id="students" name="user_id">
                            <option selected></option>
                            {% for user in allUsers %}
                            {% if user.role == 'student' %}
                            <option value="{{ user.id }}">{{ user.name }}</option>
                            {% endif %}
                            {% endfor %}
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark sml-btn">Schrijf in Student</button>
            </form>
        </div>

        <label for="enroll-name">Filter</label>
        <input type="text" class="form-control" id="enroll-name" name="enroll-name" placeholder="Zoek op ID, tentamen naam, gebruikers naam of datum" required>
        <div class="table-responsive">
            <h3><u></u></h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-white bg-dark" scope="col">Tentamen naam</th>
                    <th class="text-white bg-dark" scope="col">naam</th>
                    <th class="text-white bg-dark" scope="col">Aangemaakt op:</th>
                    <th class="text-white bg-dark" scope="col">Gewijzigd op:</th>
                    <th class="text-white bg-dark">Akties</th>
                </tr>
                </thead>
                <tbody id="enroll">
                {% for enrolled in allEnrollments %}
                <tr>
                    <td>{{ enrolled.exam_name }}</td>
                    <td>{{ enrolled.user_name }}</td>
                    <td>{{ enrolled.created_at }}</td>
                    <td>{{ enrolled.updated_at }}</td>
                    <td>
                        <a href="/users/unenroll/{{ enrolled.id }}" class="btn btn-dark float-right sml-btn">Verwijderen</a>
                    </td>
                </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#user-name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#users tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $(document).ready(function(){
        $("#enroll-name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#enroll tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
{% endif %}
{% extends layout/footer.php %}

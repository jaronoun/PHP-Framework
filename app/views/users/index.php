
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
                    <th class="text-white bg-dark"></th>
                </tr>
                </thead>
                <tbody id="exams">
                {% for user in allUsers %}
                <tr>
                    <th scope="row">{{ user.id }}</th>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role }}</td>
                    <td>{{ user.remember_token }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>{{ user.updated_at }}</td>
                    <td><button type="button" class="btn btn-danger sml-btn"> Wijzig </button></td>
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
        <label for="enroll-name">Filter</label>
        <input type="text" class="form-control" id="enroll-name" name="enroll-name" placeholder="Zoek op ID, tentamen naam, gebruikers naam of datum" required>
        <div class="table-responsive">
            <h3><u></u></h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-white bg-dark" scope="col">Tentamen naam</th>
                    <th class="text-white bg-dark" scope="col">Student naam</th>
                    <th class="text-white bg-dark" scope="col">Aangemaakt op:</th>
                    <th class="text-white bg-dark" scope="col">Gewijzigd op:</th>
                    <th class="text-white bg-dark"></th>
                </tr>
                </thead>
                <tbody id="enroll">
                {% for enrolled in allEnrollments %}
                <tr>
                    <td>{{ enrolled.exam_name }}</td>
                    <td>{{ enrolled.user_name }}</td>
                    <td>{{ enrolled.created_at }}</td>
                    <td>{{ enrolled.updated_at }}</td>
                    <td><button type="button" class="btn btn-danger sml-btn"> Wijzig </button></td>
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

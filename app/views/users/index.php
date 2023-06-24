
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
<div class="table-responsive">
    <h3><u>Alle gebruikers</u></h3>
    <table class="table table-striped" contenteditable="true">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th scope="col">password</th>
            <th scope="col">Rechten</th>
            <th scope="col">Remember token</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {% for user in data %}
        <tr>
            <th scope="row">{{ user.id }}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.password }}</td>
            <td>{{ user.role }}</td>
            <td>{{ user.remember_token }}</td>
            <td><button type="button" class="btn btn-danger"> Wijzig </button></td>
        </tr>
        {% endfor %}
        <tr>
            <th scope="row"></th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><button type="button" class="btn btn-danger"> Aanmaken </button></td>
        </tr>
        </tbody>
    </table>
</div>
{% endif %}
{% extends layout/footer.php %}

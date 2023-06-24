{% extends layout/header.php %}

<div class="row">

    {% if user.role == 'student' %}
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Meest recente resultaat</div>
            <div class="card-body">
                <h1 class="display-1 text-center">{{ grade.grade }}</h1>
                <h2 class="text-center mb-4">{{ grade.exam_id }}</h2>
                <p class="text-center mb-0">Docent: {{ grade.teacher_id }}</p>
                <p class="text-center mb-0">Invoer datum: {{ getDate(grade.created_at) }}</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Behaalde cijfers</div>
            <div class="card-body">
                <ul class="list-group">
                    {% for grade in grades %}
                    <li class="list-group-item">
                        <h5 class="mb-1">{{ grade.exam_name }}</h5>
                        <p class="mb-1">Behaald met een {{ grade.grade }}</p>
                        <small>{{ getDate(grade.created_at) }}</small>
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
            <div class="card-header text-white bg-dark">Cijfers</div>
            <div class="card-body">
                <div class="table-responsive">
                    <h3><u></u></h3>
                    <table class="table table-striped" contenteditable="true">
                        <thead>
                        <tr>
                            <th class="text-white bg-dark" scope="col">id</th>
                            <th class="text-white bg-dark" scope="col">Tentamen</th>
                            <th class="text-white bg-dark" scope="col">Student</th>
                            <th class="text-white bg-dark" scope="col">Cijfer</th>
                            <th class="text-white bg-dark" scope="col">Aangemaakt op:</th>
                            <th class="text-white bg-dark" scope="col">Gewijzigd op:</th>
                            <th class="text-white bg-dark"></th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for grade in data %}
                        <tr>
                            <th scope="row">{{ grade.id }}</th>
                            <td>{{ grade.exam_name }}</td>
                            <td>{{ grade.user_name }}</td>
                            <td>{{ grade.grade }}</td>
                            <td>{{ grade.created_at }}</td>
                            <td>{{ grade.updated_at }}</td>
                            <td><button type="button" class="btn btn-danger"> Wijzig </button></td>
                        </tr>
                        {% endfor %}
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="datetime-local"></td>
                            <td><input type="datetime-local"></td>
                            <td><button type="button" class="btn btn-danger"> Aanmaken </button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {% endif %}
</div>



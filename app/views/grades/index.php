{% extends layout/header.php %}

<div class="row mt-3">

    {% if role == student %}
    <div class="col-12 col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Meest recente resultaat</div>
            <div class="card-body">
                <h1 class="display-1 text-center">100</h1>
                <h2 class="text-center mb-4">Wiskunde</h2>
                <p class="text-center mb-0">Examendatum:</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 mb-3">
        <div class="card">
            <div class="card-header text-white bg-dark">Behaalde cijfers</div>
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
    {% endif %}


    <div>
        <table class="table table-striped" contenteditable="true">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Tentamen</th>
                <th scope="col">Student</th>
                <th scope="col">Docent(nog maken, ook in db)</th>
                <th scope="col">Cijfer</th>
                <th scope="col">Aangemaakt op:</th>
                <th scope="col">Gewijzigd op:</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {% for grade in data %}
                <tr>
                    <th scope="row">{{ grade.id }}</th>
                    <td>{{ grade.exam_name }}</td>
                    <td>{{ grade.user_name }}</td>
                    <td> - </td>
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
                <td></td>
                <td><input type="datetime-local"></td>
                <td><input type="datetime-local"></td>
                <td><button type="button" class="btn btn-danger"> Aanmaken </button></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>



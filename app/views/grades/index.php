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
                        <small>Gegeven op {{ getDate(grade.created_at) }} door {{ grade.teacher_name }}</small>
                    </li>
                    {% endfor %}
                </ul>
            </div>
        </div>
    </div>
    {% endif %}
</div>



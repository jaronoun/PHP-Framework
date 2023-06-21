
{% extends layout/header.php %}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-dark">Profiel</div>
            <div class="card-body">
                <h5 class="card-title">Name: {{ name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Email: {{ email }} </h6>
                <p class="card-text">Role: {{ role }}</p>
            </div>
        </div>
    </div>
</div>
{% extends layout/footer.php %}

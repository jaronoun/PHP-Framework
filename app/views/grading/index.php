{% extends layout/header.php %}
<form>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-header text-white bg-dark">Selecteer Tentamen</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-white bg-dark">ID</th>
                            <th class="text-white bg-dark">Naam</th>
                            <th class="text-white bg-dark">Acties</th>
                        </tr>
                        </thead>
                        <tbody id="exams">
                        {% for exam in exams %}
                        <tr>
                            <td>{{ exam.id }}</td>
                            <td>{{ exam.name }}</td>
                            <td>
                                <a href="/beoordeling/{{ exam.id }}" class="btn btn-dark sml-btn">Selecteer</a>
                            </td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-header text-white bg-dark">Selecteer Student(en)</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-white bg-dark">ID</th>
                            <th class="text-white bg-dark">Naam</th>
                            <th class="text-white bg-dark">Select</th>
                        </tr>
                        </thead>
                        <tbody id="exams">
                        {% for exam in exams %}
                        <tr>
                            <td>{{ exam.id }}</td>
                            <td>{{ exam.name }}</td>
                            <td></td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-header text-white bg-dark">Geef Cijfer</div>
                <div class="card-body">
            </div>
        </div>

    </div>
</form>

{% extends layout/footer.php %}
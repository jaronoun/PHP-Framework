{% extends layout/header.php %}

<div class="card">
    <div class="card-header">Beoordeel Tentamen</div>
    <div class="card-body">
        <form>
            <div class="form-group mb-3">
                <label for="examSelect">Selecteer Tentamen:</label>
                <select class="form-control" id="examSelect">
                    <option>Exam 1</option>
                    <option>Exam 2</option>
                    <option>Exam 3</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="studentSelect">Selecteer Student:</label>
                <select class="form-control" id="studentSelect">
                    <option>Student 1</option>
                    <option>Student 2</option>
                    <option>Student 3</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="gradeInput">Cijfer:</label>
                <input type="text" class="form-control" id="gradeInput" placeholder="Enter grade">
            </div>
            <button type="submit" class="btn btn-dark sml-btn">Submit</button>
        </form>
    </div>
</div>

{% extends layout/footer.php %}
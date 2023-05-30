{% extends layout/header.php %}
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Grading Page</h2>
            <form>
                <div class="form-group">
                    <label for="examSelect">Select Exam:</label>
                    <select class="form-control" id="examSelect">
                        <option>Exam 1</option>
                        <option>Exam 2</option>
                        <option>Exam 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="studentSelect">Select Student:</label>
                    <select class="form-control" id="studentSelect">
                        <option>Student 1</option>
                        <option>Student 2</option>
                        <option>Student 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gradeInput">Enter Grade:</label>
                    <input type="text" class="form-control" id="gradeInput" placeholder="Enter grade">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
{% extends layout/footer.php %}
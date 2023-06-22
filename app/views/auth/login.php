{% extends layout\header.php %}

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-white bg-dark">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form action="/login" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="username" class="form-label">Email address</label>
                        <input name="username" type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{% extends layout\footer.php %}
<!-- Include Bootstrap JS -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.min.js"></script>-->
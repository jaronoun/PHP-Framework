<?php?>
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Register</h3>
        </div>
        <div class="card-body">
          <form action="/register" method="POST" enctype="application/x-www-form-urlencoded">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input name="name" type="text" class="form-control" id="name" placeholder="Enter name">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input name="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select name="role" class="form-select" id="role">
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
              </select>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
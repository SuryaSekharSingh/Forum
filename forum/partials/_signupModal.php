<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" >
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="signupModalLabel">signup for a colliDEA Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/forum/partials/_handleSignup.php" method="POST">
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Username</label>
                        <input type="text" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="signuppassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signuppassword" name="signuppassword">
                    </div>
                    <div class="mb-3">
                        <label for="signupcpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="signupcpassword" name="signupcpassword">
                        <div id="emailHelp" class="form-text">Make sure you take the same password.</div>
                    </div>
                    <!-- <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> -->
                    <button type="submit" class="btn btn-primary">Signup</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
    </div>
  </div>
</div>
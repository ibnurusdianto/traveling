<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/forgot_password.css">
    <title>Forgot Password</title>
</head>
<body>
<!-- Forgot Password -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card text-white bg-primary">
        <div class="card-header text-center">Forgot Password</div>
        <div class="card-body">
          <form action="./function-login-diluar-admin/function_forgot_password.php" method="post">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
              <label for="username" class="form-label">Enter your username</label>
            </div>
            <button type="submit" class="btn btn-primary">Check username</button><br><br>
            <button type="button" class="btn btn-primary" onclick="location.href='login.php';">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Forgot Password -->
</body>
</html>

<a href="login.php"></a>


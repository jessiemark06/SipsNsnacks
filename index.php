<?php 
require_once "includes/config_session.inc.php";
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    if ($_SESSION["user_role"] === "admin") {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: staff/staff_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SipsNSnacks</title>
 <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
 
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #EAE4D5">

    <div class="container" >
      <a class="navbar-brand fw-bold" href="index.php"><img class="navbar-brand" src="assets/img/logo.png" style="width: 70px; height: auto;">Sips'NSnacks</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item "><a class="nav-link text-dark" href="login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

 
  <section class="vh-100 d-flex align-items-center justify-content-center text-center text-white "
        style="background-image: url('assets/img/bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container ">
      <h1 class="display-3 fw-bold" style="color: #EAE4D5;" >Welcome to Sips'NSnacks</h1>
      <p class="lead fw-bold">Your go-to spot for tasty treats and refreshing drinks!</p>
    </div>
  </section>

 
  <footer class="bg-dark text-white text-center py-3">
    &copy; 2025 SipsNSnacks. All rights reserved.
  </footer>


</body>
</html>
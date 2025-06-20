<?php 
require_once "includes/config_session.inc.php";
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    if ($_SESSION["user_role"] === "admin") {
        header("Location: admin/admin_dashboard.php");
        exit();
    } else {
        header("Location: staff/staff_dashboard.php");
        exit();
    }
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-image: url('assets/img/bg-log.jpg'); background-size: cover; background-position: center;" class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="d-flex flex-column flex-md-row shadow-lg" style="max-width: 900px; width: 100%; background: #292929; border-radius: 15px; overflow: hidden;">

        <div class="d-flex flex-column justify-content-center align-items-center text-center col-md-6" 
             style="background-color: #EAE4D5; padding: 2rem; min-height: 300px;">
            <a href="index.php">
            <img src="assets/img/logo.png" alt="Logo" style="width: 175px; height: auto;" class="mb-3">
            </a>
            <a href="index.php" class="text-decoration-none"><h2 class="fw-bold" style="color: #000;">Sips'NSnacks</h2></a>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center col-md-6" 
             style="padding: 2rem; background: #292929; min-height: 300px;">
            <div style="width: 100%; max-width: 320px;">
                <h2 class="text-center mb-4" style="color: #EAE4D5;">Sign In</h2>
                <form id="myForm" action="includes/login.inc.php" method="post">
                    <div class="mb-2">
                        <label for="email" class="form-label" style="color: white;">Email</label>
                        <input name="email" type="text" class="form-control" id="email" placeholder="Enter Email">
                    </div>
                    <div class="mb-4">
                        <label for="pass1" class="form-label" style="color: white;">Password</label>
                        <input name="pass1" type="password" class="form-control" id="pass1" placeholder="Enter Password">
                        <div class="text-center mt-2">
                            <?php if (isset($_SESSION["errors_login"]["login_wrong"])): ?>
                                <span class="text-danger small"><?php echo $_SESSION["errors_login"]["login_wrong"]; ?></span>
                            <?php endif; ?>
                        </div>       
                    </div>
                    
                    <div class="d-grid gap-2 mb-2">
                        <button type="submit" class="btn rounded-4" 
                                style="background: #EAE4D5; color: #000;">Sign In</button>
                        <a href="signup.php" class="btn rounded-4" 
                           style="border: 1px solid #EAE4D5; color: #EAE4D5; background: #292929;">Sign Up</a>
                           
                    </div>
                    
                </form>
                <?php unset($_SESSION["errors_login"]); ?>
            </div>
        </div>

    </div>

</body>
</html>
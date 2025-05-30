<?php
require_once 'includes/config_session.inc.php';
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-dark" style="background-image: url('assets/img/bg-log.jpg'); background-size: cover; background-position: center;">

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container shadow-lg p-0" style="max-width: 600px; background: #292929; overflow-y: auto;border-radius: 15px;">
            <div class="p-4">
                <h2 class="mb-4 text-center" style="color: #EAE4D5;">Sign Up</h2>
                <form id="myForm" action="includes/signup.inc.php" method="post">
                    <div class="row mb-2 mx-3">
                        <div class="col-sm-6">
                            <label for="fname" class="form-label text-white">Firstname</label>
                            <input name="fname" type="text" class="form-control" id="fname" placeholder="Enter Firstname" value="<?= htmlspecialchars($_SESSION['old_inputs']['fname'] ?? '') ?>">
                            <?php if (isset($_SESSION['errors_signup']['fname'])): ?>
                                 <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['fname']) ?></span>
                            <?php endif; ?>                        
                        </div>
                        <div class="col-sm-6 ">
                            <label for="mname" class="form-label text-white">Middlename</label>
                            <input name="mname" type="text" class="form-control" id="mname" placeholder="Enter Middlename" value="<?= htmlspecialchars($_SESSION['old_inputs']['mname'] ?? '') ?>">
                            <?php if (isset($_SESSION['errors_signup']['mname'])): ?>
                                 <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['mname']) ?></span>
                            <?php endif; ?>             
                        </div>
                    </div>
                    <div class="mx-3 row mb-2">
                        <div class="col-sm-6 ">
                            <label for="lname" class="form-label text-white">Lastname</label>
                            <input name="lname" type="text" class="form-control" id="lname" placeholder="Enter Lastname" value="<?= htmlspecialchars($_SESSION['old_inputs']['lname'] ?? '') ?>">
                            <?php if (isset($_SESSION['errors_signup']['lname'])): ?>
                                 <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['lname']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6 ">
                            <label for="addr" class="form-label text-white">Address</label>
                            <input name="addr" type="text" class="form-control" id="addr" placeholder="Enter Address" value="<?= htmlspecialchars($_SESSION['old_inputs']['addr'] ?? '') ?>">
                            <?php if (isset($_SESSION['errors_signup']['addr'])): ?>
                                 <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['addr']) ?></span>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                    <div class="mx-3 row mb-2">
                        <div class="col-sm-6">
                            <label for="conum" class="form-label text-white">Contact Number</label>
                            <input name="conum" type="text" class="form-control" id="conum" placeholder="Enter Contact Number" value="<?= htmlspecialchars($_SESSION['old_inputs']['conum'] ?? '') ?>">
                            <?php if (isset($_SESSION['errors_signup']['conum'])): ?>
                                <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['conum']) ?></span>
                            <?php endif; ?>    
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="form-label text-white">Email</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="Enter Email" value="<?= htmlspecialchars($_SESSION['old_inputs']['email'] ?? '') ?>">
                            <?php if (isset($_SESSION['errors_signup']['email_invalid'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['email_invalid']) ?></span>
                               <?php endif; ?>  
                             <?php if (isset($_SESSION['errors_signup']['email_registered'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['email_registered']) ?></span>
                               <?php endif; ?> 
                        </div>
                        
                    </div>
                    <div class="mx-3 row mb-4">
                        <div class="col-sm-6 ">
                            <label for="pass1" class="form-label text-white">Password</label>
                            <input name="pass1" type="password" class="form-control" id="pass1" placeholder="Enter Password">
                        </div>
                        <div class="col-sm-6 ">
                            <label for="pass2" class="form-label text-white">Confirm Password</label>
                            <input name="pass2" type="password" class="form-control" id="pass2" placeholder="Confirm Password">
                        </div>
                        <?php if (isset($_SESSION['errors_signup']['password_not'])): ?>
                            <span class="text-center text-danger small"><?= htmlspecialchars($_SESSION['errors_signup']['password_not']) ?></span>
                        <?php endif; ?> 
                    </div>
                    <div class="mb-1 d-flex justify-content-center">
                        <button type="submit" class="btn rounded-4 text-dark" style="background-color: #EAE4D5; width: 300px;">Sign Up</button>
                    </div>
                    <div class="text-center">
                        <p class="text-white">Already have an account?
                            <a href="index.php" class="text-decoration-none" style="color:#EAE4D5;">Sign In</a>
                        </p>
                    </div>
                </form>

                

            </div>
        </div>
    </div>
<?php

if (isset($_SESSION['errors_signup'])) {
    unset($_SESSION['errors_signup']);
}
if (isset($_SESSION['old_inputs'])) {
    unset($_SESSION['old_inputs']);
}
?>

</body>
</html>
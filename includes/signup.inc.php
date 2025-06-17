<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $fname = trim($_POST["fname"]);
    $mname = trim($_POST["mname"]);
    $lname   = trim($_POST["lname"]);
    $addr = trim($_POST["addr"]);
    $conum = trim($_POST["conum"]);
    $email = trim($_POST["email"]);
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];

    try{

    require_once("dbh.inc.php");
    require_once("signup_contr.inc.php");
    require_once "signup_model.inc.php";

    
    $errors = [];
    if (empty($fname)){
    $errors["fname"] = "Firstname is required!";
    }
    if (empty($mname)){
    $errors["mname"] = "Middlename is required!";
    }
    if (empty($lname)){
    $errors["lname"] = "Lastname is required!";
    }
    if (empty($addr)){
    $errors["addr"] = "Address is required!";
    }
    if (empty($conum)) {
    $errors["conum"] = "Contact number is required!";
    }elseif (!ctype_digit($conum)) {
    $errors["conum"] = "Contact number must contain digits only!";
    }elseif (!empty($conum) && !preg_match("/^[0-9]{11}$/", $conum)) {
        $errors["conum"] = "Contact number must be 11 digits!";
    }
        
    if (is_email_invalid( $email)){
    $errors["email_invalid"] = "Invalid Email!";    
    }
    if (is_email_registered( $pdo, $email)){
    $errors["email_registered"] = "Email already registered!";    
    }
    if(strlen($pass1) < 6){
        $errors["password_not"] = "Password must be atleast 6 characters!";
    }elseif($pass1 != $pass2){
        $errors["password_not"] = "Password does not match!";
    }
    

    require_once("config_session.inc.php");

    if($errors){
        $_SESSION["errors_signup"] = $errors;

        $_SESSION["old_inputs"] = [
        'fname' => $fname,
        'mname' => $mname,
        'lname' => $lname,
        'addr' => $addr,
        'conum' => $conum,
        'email' => $email
        ];


        header("location: ../signup.php");
        exit();
        

    }

    create_user($pdo,  $fname,  $mname,  $lname,  $addr,  $conum,
 $email,  $pass1);

    header("location: ../signup.php");

    $pdo = null;
    $stmt = null;
    die();

      }catch(PDOException $e){
            die("Query Failed: ". $e->getMessage());
          }


}else{
    header("location: ../signup.php" );
    die();
}

?>
<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
     $email = trim($_POST["email"]);
     $pass1 = $_POST["pass1"];

     try{

        require_once("dbh.inc.php");
        require_once("login_contr.inc.php");
        require_once("login_model.inc.php");

        $errors = [];
       

       $result = get_email($pdo, $email);

       if(is_input_empty($email, $pass1)){
            $errors["login_wrong"] = "Invalid Email or Password!";
        }elseif(is_email_wrong($result)){

            $errors["login_wrong"] = "Invalid Email or Password!";

       }elseif(!is_email_wrong($result) && is_password_wrong($pass1, $result["pass1"])){

            $errors["login_wrong"] = "Invalid Email or Password!";

       }
    

    require_once("config_session.inc.php");

    if($errors){
        $_SESSION["errors_login"] = $errors;

        header("location: ../Login.php");
        exit();
    }

    $_SESSION["user_id"] = $result["acc_id"];           
    $_SESSION["user_email"] = $result["email"];
    $_SESSION["user_role"] = $result["role"];       
    $_SESSION["logged_in"] = true;

    if ($_SESSION["user_role"] === "admin") {
    header("Location: ../admin_dashboard.php");
    exit();

    } else {
    header("Location: ../cust_dashboard.php");
    exit();
        }

     }catch(PDOException $e){

        die("Query Failed: ". $e->getMessage());
        
     }


}else{
    header("location: ../index.php" );
    die();
}
?>
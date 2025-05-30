<?php

declare(strict_types= 1);

function is_input_empty(string $fname,string $mname,string $lname,string $addr,string $conum,string $email, string $pass1,string $pass2){
    if(empty($fname) || empty($mname) || empty($lname) || empty($addr) || empty($conum) || empty($email)
    || empty($pass1) || empty($pass2)){
             return true;

    }
    else{
        return false;
    }
}

function is_email_invalid(string $email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
             return true;

    }
    else{
        return false;
    }
}

function is_email_registered(object $pdo, string $email){
    if(get_email($pdo, $email)){
             return true;

    }
    else{
        return false;
    }
}

function create_user(object $pdo, string $fname, string $mname, string $lname, string $addr, string $conum,
string $email, string $pass1){
    set_user( $pdo,  $fname,  $mname,  $lname,  $addr, $conum,
 $email, $pass1);
}

?>


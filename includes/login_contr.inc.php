<?php

declare(strict_types= 1);   

function is_input_empty(string $email, string $pass1){

    if(empty($email) || empty($pass1)){
        return true;
    }else{
        return false;
    }

}
function is_email_wrong(array | bool $result){

    if (!$result){
        return true;
    }   else {
        return false;
    }

}

function is_password_wrong(string $pass1, string $hashedpass1){

    if (!password_verify($pass1, $hashedpass1)){
        return true;
    }   else {
        return false;
    }

}
?>
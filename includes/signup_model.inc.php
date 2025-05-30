<?php

declare(strict_types= 1);   

function get_email(object $pdo, string $email){
    $query = "SELECT email FROM acc_tbl WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam (":email",$email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function set_user(object $pdo, string $fname, string $mname, string $lname, string $addr, string $conum,
string $email, string $pass1){

    $query = "INSERT INTO acc_tbl (fname, mname, lname, addr, conum, email, pass1) 
    VALUES (:fname, :mname, :lname, :addr, :conum,:email, :pass1);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashedpass1 = password_hash($pass1, PASSWORD_BCRYPT, $options);

    $stmt->bindParam (":fname", $fname);
    $stmt->bindParam (":mname", $mname);
    $stmt->bindParam (":lname", $lname);
    $stmt->bindParam (":addr", $addr);
    $stmt->bindParam (":conum", $conum);
    $stmt->bindParam (":email", $email);
    $stmt->bindParam (":pass1", $hashedpass1);
    $stmt->execute();

}


?>
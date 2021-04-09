<?php


/********/
/*  ดาต้าเบส
    mysql:host: localhost
    dbname: scholarship
    username: root
    password: ""
*/
/********/


try {
    $conn = new PDO("mysql:host=localhost; dbname=scholarship", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

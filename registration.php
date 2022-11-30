<?php
    include 'dbconnect.php';
    include 'responseStore.php';
    
    $name = $_GET['name'];
    $login = $_GET['login'];
    $password = $_GET['password'];

    if(!($name && $login && $password)) die(errProperty('name,login,password'));
    
    
    $SQL_SELECT_LOGIN = "SELECT * FROM users WHERE login = '$login'";
    if($response = $conn->query($SQL_SELECT_LOGIN)){
        if($response->num_rows > 0) die(loginExist($login));
    }else{
        die($ERROR_QUERY_DB);
    }
    
    $hashpassword = md5($password);
    $SQL_INSERT_USER = "INSERT INTO users (name, login, password) VALUES('$name', '$login', '$hashpassword')";
    if($conn->query($SQL_INSERT_USER)){
        die($OK);
    }else{
        die($ERROR_QUERY_DB);
    }
?>
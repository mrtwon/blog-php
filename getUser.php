<?php
    include 'dbconnect.php';
    $findLogin = $_GET['searchLogin'];
    if($conn->connect_error) die('error connect to db...');
    if(!$findLogin) die('searchLogin no set');
    $sql = "SELECT * FROM Users WHERE login = '$findLogin'";
    if($result = $conn->query($sql)){
        foreach($result as $row){
            echo $row['login'].' | '.$row['id'];
        }
    }else{
        die('error request to db...');
    }
?>
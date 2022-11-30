<?php
    include 'dbconnect.php';
    include 'responseStore.php';

    $act = $_GET['act'];
    if(!$act) die('field act is empty...');


    if($act == 'login'){
        $login = $_GET['login'];
        $password = $_GET['password'];
        if(!$login || !$password) die(errProperty('login,password'));
        
        
        $hashPassword = md5($password);
        $SQL_EQUALS_AUTH_DATA = "SELECT id,login,name FROM users WHERE login = '$login' and password = '$hashPassword'";

        if($result = $conn->query($SQL_EQUALS_AUTH_DATA)){
            if($result->num_rows > 0){
                $hash = md5(date('m.d.Y H:i:s').$login.$password);
                $userId = $result->fetch_array()['id'];
                $SQL_INSERT_NEW_SESSION = "INSERT INTO auth (userId, hash) VALUES('$userId', '$hash')";
                if ($conn->query($SQL_INSERT_NEW_SESSION)){
                    setcookie("token", $hash,time()+3600*24);
                    $SQL_SELECT_USER = "SELECT id,login,name FROM users WHERE id = '$userId'";
                    $responseSelectUser = $conn->query($SQL_SELECT_USER);
                    die(generateOkResponse([mysqli_fetch_assoc($responseSelectUser)]));
                }
                die($ERROR_ADD_TOKEN);
            }
            die($ERROR_LOGIN_OR_PASSWORD);
        }
        die($ERROR_QUERY_DB);
    }
    elseif($act == 'logout'){
        $hash = $_COOKIE['token'];
        if(!$hash) die($ERROR_HASH_NOT_EXIST);
        $SQL_SELECT_HASH = "SELECT * FROM auth WHERE hash = '$hash'";
        $SQL_REMOVE_HASH = "DELETE FROM auth WHERE hash = '$hash'";
        if($resultSelectHash = $conn->query($SQL_SELECT_HASH)){
            if($resultSelectHash->num_rows == 0) die($ERROR_HASH_NOT_EXIST);
            if($resultRemoveHash = $conn->query($SQL_REMOVE_HASH)){
                setcookie("token", '',time());
                die($OK);
            }
            die($ERROR_QUERY_DB);
        }
        die($ERROR_QUERY_DB);
    }
    elseif($act == 'checkLogin'){
        include 'helper.php';
        $hash = $_COOKIE['token'];
        if(!$hash) die($ERROR_HASH_NOT_EXIST);
        $SQL_SELECT_HASH = "SELECT userId FROM auth WHERE hash = '$hash'";
        $responseSelectByHash = $conn->query($SQL_SELECT_HASH);
 
        if(!$responseSelectByHash) die($ERROR_QUERY_DB);
        if($responseSelectByHash->num_rows == 0) die($ERROR_NOT_AUTH);
        $userId = mysqli_fetch_assoc($responseSelectByHash)['userId'];
        
        $SQL_SELECT_USER = "SELECT id,login,name FROM users WHERE id = '$userId'";
        $responseSelectUser = $conn->query($SQL_SELECT_USER);
      
        if(!$responseSelectUser) die($ERROR_QUERY_DB);
        if($responseSelectUser->num_rows == 0) die($ERROR_USER_NOT_FOUND);
        die(generateOkResponse([mysqli_fetch_assoc($responseSelectUser)]));

    }
    die(errProperty('act'));
?>
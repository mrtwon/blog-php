<?php
    include 'dbconnect.php';
    
    $token = $_COOKIE['token'];
    if(!$token) die($ERROR_NOT_AUTH);
    $SQL_SELECT_AUTH = "SELECT userId FROM auth WHERE hash = '$token'";
    $responseSelectAuth = $conn->query($SQL_SELECT_AUTH);
    if(!$responseSelectAuth) die($ERROR_QUERY_DB);
    if($responseSelectAuth->num_rows == 0) die($ERROR_NOT_AUTH);
    $uid = $responseSelectAuth->fetch_array()['userId'];

    function giveFullPostInfo($postId, $userId){
        include 'dbconnect.php';
        $SQL_SELECT_POST = "SELECT * FROM posts WHERE id = '$postId'";
        $responseSelectPost = $conn->query($SQL_SELECT_POST);
        $responseSelectPostArr = mysqli_fetch_assoc($responseSelectPost);
        $SQL_SELECT_USER = "SELECT id,login,name FROM users WHERE id = '$userId'";
        $responseSelectUser = $conn->query($SQL_SELECT_USER);
        if(!$responseSelectUser){
            die($ERROR_QUERY_DB);
        }
        $responseSelectUserArray = mysqli_fetch_assoc($responseSelectUser);

        $SQL_SELECT_LIKES = "SELECT * FROM likes WHERE postId = '$postId'";
        $responseSelectLikes = $conn->query($SQL_SELECT_LIKES);
        if(!$responseSelectLikes) die($ERROR_QUERY_DB);


        $arrLikes = [];
        while($oneOfArrLikes = mysqli_fetch_assoc($responseSelectLikes)){
            $arrLikes[] = $oneOfArrLikes;
        }
        
        return [
            'post'=>$responseSelectPostArr,
            'user'=>$responseSelectUserArray,
            'likes'=>$arrLikes
        ];
    }
?>
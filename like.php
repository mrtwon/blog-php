<?php
    include 'responseStore.php';
    include 'helper.php';
    $act = $_GET['act'];
    $postId = $_GET['postId'];

    if(!$act || !$postId) die(errProperty('act,postId'));

    include 'dbconnect.php';


    if($act == 'add'){
        $SQL_SELECT_ONE_LIKES = "SELECT * FROM likes WHERE userId = '$uid' and postId = '$postId'";
        $responseSelectLike = $conn->query($SQL_SELECT_ONE_LIKES);
        if($responseSelectLike->num_rows > 0 ) die($ERROR_LIKE_IS_EXIST);
        $SQL_INSERT_LIKES = "INSERT INTO likes(userId, postId) VALUES ('$uid','$postId')";
        $responseInsertLike = $conn->query($SQL_INSERT_LIKES);
        if(!$responseInsertLike) die($ERROR_QUERY_DB);

        $SQL_LAST_LIKE = "SELECT * FROM likes WHERE postId = '$postId' and userId = '$uid'";
        $responseLastLike = $conn->query($SQL_LAST_LIKE);
        if(!$responseLastLike) die($ERROR_QUERY_DB);
        die(generateOkResponse([mysqli_fetch_assoc($responseLastLike)]));
    }
    elseif($act == 'remove'){
        $SQL_SELECT_LIKE = "SELECT * FROM likes WHERE postId = '$postId' and userId = '$uid'";
        $responseSelectLike = $conn->query($SQL_SELECT_LIKE);
        if(!$responseSelectLike) die($ERROR_QUERY_DB);

        $SQL_REMOVE_LIKE = "DELETE FROM likes WHERE postId = '$postId' and userId = '$uid'";
        $responseRemoveLike = $conn->query($SQL_REMOVE_LIKE);
        if(!$responseRemoveLike) die($ERROR_QUERY_DB);
        
        die(generateOkResponse([mysqli_fetch_assoc($responseSelectLike)]));
    }
    die($ERROR_NOT_VALID_REQUEST);

?>
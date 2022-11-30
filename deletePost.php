<?php
    include 'responseStore.php';
    include 'helper.php';
    $removePostId = $_GET['postId'];
    if(!$removePostId) die(errProperty('postId'));

    include 'dbconnect.php';

    $SQL_SELECT_POST_UID = "SELECT * FROM posts WHERE id = '$removePostId'";
    $responseSelectPostUid = $conn->query($SQL_SELECT_POST_UID);
    $postUid = $responseSelectPostUid->fetch_array()['userId'];

    if($postUid != $uid) die($ERROR_FORBIDDEN);

    $SQL_DELETE_POST = "DELETE FROM posts WHERE id = '$removePostId'";
    $responseDeletePost = $conn->query($SQL_DELETE_POST);
    if(!$responseDeletePost) die($ERROR_QUERY_DB);
    die($OK);
?>
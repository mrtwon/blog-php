<?php
        include 'responseStore.php';
        include 'helper.php';

        // Get JSON as a string
        $json_str = file_get_contents('php://input');
        // Get as an object
        $json_obj = json_decode($json_str, true);
        $title = $json_obj['title'];
        $body = $json_obj['body'];
        if(!$title || !$body) die(errProperty('title,body'));

        include 'dbconnect.php';

        $SQL_ADD_NEW_POST = "INSERT INTO posts (userId, title, body) VALUES('$uid', '$title', '$body')";
        $responseAddNewPost = $conn->query($SQL_ADD_NEW_POST);
        if(!$responseAddNewPost) die($ERROR_QUERY_DB);
        
        $SQL_LAST_POST = "SELECT * FROM posts WHERE id = (SELECT max(id) FROM posts) and userId = '$uid'";
        $responseLastPost = $conn->query($SQL_LAST_POST);
        if(!$responseLastPost) die($ERROR_QUERY_DB);

        $responseLastPostArr = mysqli_fetch_assoc($responseLastPost);
        $fullPostInfo = giveFullPostInfo($responseLastPostArr['id'],$responseLastPostArr['userId']);
        die(generateOkResponse([$fullPostInfo]));
?>
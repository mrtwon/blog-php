<?php   
    
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    include 'responseStore.php';
    include 'helper.php';

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);
    
    $postId = $json_obj['id'];
    $postUid = $json_obj['userId'];
    $title = $json_obj['title'];
    $body = $json_obj['body'];
    if(!$postId || !$postUid || !$title || !$body) die(errProperty('id,userId,title,body'));

    include 'dbconnect.php';
    

    $SQL_SELECT_POST = "SELECT * FROM posts WHERE id = '$postId'";
    $responseSelectPost = $conn->query($SQL_SELECT_POST);
    if(!$responseSelectPost) die($ERROR_QUERY_DB);
    $updatePostUId = $responseSelectPost->fetch_array()['userId'];
    if($updatePostUId != $uid) die($ERROR_FORBIDDEN);

    $SQL_UPDATE_POST = "UPDATE posts SET title = '$title', body = '$body' WHERE id = '$postId'";
    $responseUpdatePost = $conn->query($SQL_UPDATE_POST);
    if(!$responseUpdatePost) die($ERROR_QUERY_DB);

    $SQL_LAST_POST = "SELECT * FROM posts WHERE id = '$postId'";
    $responseLastPost = $conn->query($SQL_LAST_POST);
    if(!$responseLastPost) die($ERROR_QUERY_DB);
    $responseLastPostArr = mysqli_fetch_assoc($responseLastPost);
    $fullPostInfo = giveFullPostInfo($responseLastPostArr['id'],$responseLastPostArr['userId']);
    die(generateOkResponse([$fullPostInfo]));
?>
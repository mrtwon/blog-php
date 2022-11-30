<?php
    include 'responseStore.php';
    include 'dbconnect.php';

    $SQL_SELECT_POSTS = "SELECT * FROM posts ORDER BY id DESC";
    $result = $conn->query($SQL_SELECT_POSTS);
    if(!$result) die($ERROR_QUERY_DB);
    
    $test = [];
    while($arrAsoc = mysqli_fetch_assoc($result)){
        $userId = $arrAsoc['userId'];
        $postId = $arrAsoc['id'];
        
        $SQL_SELECT_USER = "SELECT id,login,name FROM users WHERE id = '$userId'";
        $responseSelectUser = $conn->query($SQL_SELECT_USER);
        if(!$responseSelectUser) die($ERROR_QUERY_DB);
        $responseSelectUserArray = mysqli_fetch_assoc($responseSelectUser);

        $SQL_SELECT_LIKES = "SELECT * FROM likes WHERE postId = '$postId'";
        $responseSelectLikes = $conn->query($SQL_SELECT_LIKES);
        if(!$responseSelectLikes) die($ERROR_QUERY_DB);


        $arrLikes = [];
        while($oneOfArrLikes = mysqli_fetch_assoc($responseSelectLikes)){
            $arrLikes[] = $oneOfArrLikes;
        }
        
        $test[] = [
            'post'=>$arrAsoc,
            'user'=>$responseSelectUserArray,
            'likes'=>$arrLikes
        ];

    }
    echo generateOkResponse($test);
    
    
    // $returnArray = ['response'=>[]];
    // while($arrAsoc = mysqli_fetch_assoc($result)){
    //     $returnArray['response'][] = $arrAsoc;
    // }
    // echo json_encode($returnArray);


    /*
    {
        response:{
            post:{
                id: 100,
                userId:1,
                title: 'hello',
                body: 'world'
            },
            author:{
                userId:1,
                name:mrtwon,
                login:mrtwon88
            },
            likes:[
                  {
                    userId:1,
                    postId:10,
                  }
                ]
        }
    }
    */
?>
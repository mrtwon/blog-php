<?php
    function errProperty($name){
        return generateErrorResponse("property $name not found");
    }
    function loginExist($login){
        return generateErrorResponse("login '$login' already exising");
    }
    function generateOkResponse($response){
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        $result = ['ok'=>true,'error'=>'','response'=>[]];
        if($response){
            $result['response'] = $response;
        }
        return json_encode($result);
    }
    function generateErrorResponse($error){
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        return json_encode(['ok'=>false,'error'=>$error,'response'=>[]]);
    }
    $OK = generateOkResponse(null);
    $ERROR_CONNECT = generateErrorResponse('error connect to db');
    $ERROR_QUERY_DB = generateErrorResponse('error query to db');
    $ERROR_ADD_TOKEN = generateErrorResponse('error add token to db');
    $ERROR_LOGIN_OR_PASSWORD = generateErrorResponse('login or password is not valid');
    $ERROR_HASH_NOT_EXIST = generateErrorResponse('hash is not existing');
    $ERROR_NOT_AUTH = generateErrorResponse('no valid token');
    $ERROR_POST_NOT_DELETED = generateErrorResponse('post not deleted');
    $ERROR_FORBIDDEN = generateErrorResponse("you can't do it");
    $ERROR_LIKE_IS_EXIST = generateErrorResponse('like is existing');
    $ERROR_NOT_VALID_REQUEST = generateErrorResponse('not valid request');
    $ERROR_USER_NOT_FOUND = generateErrorResponse('user not found');
?>
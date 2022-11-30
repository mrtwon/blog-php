<?php
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname = 'blog';
            $conn = new mysqli($servername, $username, $password, $dbname);
            if($conn->connect_error) die($ERROR_QUERY_DB)
?>
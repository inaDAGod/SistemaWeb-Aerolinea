<?php
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $username= $data->username;
    $password= $data->password;
    //$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
    echo $json;
    


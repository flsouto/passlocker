<?php

$data = json_decode(file_get_contents('data.json'), true);

if(isset($_GET['new'])){
    if(empty($_GET['old_pass']) || $_GET['old_pass']!=$data['password']){
        die("old_pass param missing or invalid");
    }
    $data['password'] = substr(md5(uniqid()),0,14);
    $data['last_time'] = time();
    file_put_contents('data.json', json_encode($data));
    echo "New password: $data[password]";
} else if(isset($_GET['reset'])) {
    $data['solution'] = '';
    $data['last_time'] = time();
    file_put_contents('data.json', json_encode($data));
} else {
    if( (time() - $data['last_time']) >= 180 && strlen($data['solution']) < strlen($data['password']) ){
        $pos = strlen($data['solution']);
        $data['solution'] .= substr($data['password'], $pos, 1);
        $data['last_time'] = time();
        file_put_contents("data.json",json_encode($data));
    }
    echo 'Elapsed: '.(time()-$data['last_time'])."s<br/>";
    echo 'Solution: '.$data['solution'];
}

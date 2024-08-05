<?php
file_put_contents("data.json",json_encode([
    'password' => substr(md5(uniqid()),0,14),
    'solution' => '',
    'last_time' => time()
]));

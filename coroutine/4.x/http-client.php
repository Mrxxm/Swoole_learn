<?php

Co\run(function (){
    $cli = new Swoole\Coroutine\Http\Client('127.0.0.1', 8000);
    $cli->get('/index.php');
    echo $cli->body;
    $cli->close();
});

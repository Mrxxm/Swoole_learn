<?php

//高性能HTTP服务器
$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->on("request", function ($request, $response) {

    $cli = new Swoole\Coroutine\Http\Client('127.0.0.1', 8000);

    $cli->set(
        [
            'timeout' => 3.0
        ]
    );

    $cli->get('/api/v1/banner/1');
    echo $cli->body;
    // 状态码
    echo $cli->statusCode;
    $cli->close();

    // 发送http响应体，并结束请求处理
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>" . json_encode(json_decode($cli->body, true)));
});

$http->start();

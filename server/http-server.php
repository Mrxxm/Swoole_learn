<?php

//高性能HTTP服务器
$http = new Swoole\Http\Server("127.0.0.1", 9501);

// 开启静态文件
$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => '/var/www/swoole/data',
    ]
);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) {
    $get = $request->get;
    // 发送http响应体，并结束请求处理
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>" . json_encode($get));
});

$http->start();

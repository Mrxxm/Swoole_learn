<?php

/*
 * 此文件支持：http server & websocket server
 */

Co\run(function () {

    $server = new Co\Http\Server("127.0.0.1", 9502, false);

    // 开启静态文件
    $server->set(
        [
            'enable_static_handler' => true,
            'document_root' => '/var/www/swoole/data',
        ]
    );

//    $server->handle('/', function ($request, $response) {
//        $response->end("<h1>Index</h1>");
//    });

    $server->handle('/websocket', function ($request, $ws) {
        $ws->upgrade(); // 向客户端发送websocket握手信息

        while (true) {
            $frame = $ws->recv();
            if ($frame === false) {
                echo "error : " . swoole_last_error() . "\n";
                break;
            } else if ($frame == '') {
                break;
            } else {
                if ($frame->data == "close") {
                    $ws->close();
                    return;
                }
                $ws->push("Hello {$frame->data}!");
                $ws->push("How are you, {$frame->data}?");
            }
        }
    });



    $server->start();
});

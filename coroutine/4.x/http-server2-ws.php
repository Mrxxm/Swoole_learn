<?php

/*
 * 此文件支持：http server & websocket server
 */

Co\run(function () {

    $server = new Co\Http\Server("127.0.0.1", 8812, false);

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

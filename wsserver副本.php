<?php

/**第一个版本
use Workerman\Worker;  
require_once 'Workerman/Autoloader.php';  
  
//创建一个Worker监听127.0.0.1:8000, 使用websocket协议通讯  
$ws_worker = new Worker("websocket://127.0.0.1:8000");  
  
//启动4个进程对外提供服务  
$ws_worker->count = 4;  
  
//当接收到客户端发来的数据后显示数据并回发到客户端  
$ws_worker->onMessage = function($connection, $data) {  
    //显示数据  
    echo "you just received: $data\n";  
      
    //向客户端回发数据  
    $connection->send("you just send: $data");  
};  
  
//运行worker  
$ws_worker->runAll();  
**/

/**
* 存入数据库版本
**/
use Workerman\Worker;  
require_once 'Workerman/Autoloader.php';  
  
//创建一个Worker监听127.0.0.1:8000, 使用websocket协议通讯  
$ws_worker = new Worker("websocket://127.0.0.1:8000");  
  
//启动4个进程对外提供服务  
$ws_worker->count = 4;  
  
//初始化数据库连接  
$dsn = "mysql:host=localhost;dbname=edu;port=3306";  
$user = "root";  
$pwd = "root";  
$pdo = new PDO($dsn, $user, $pwd);  
//var_dump($pdo);die;  
//当接收到客户端发来的数据后显示数据并回发到客户端  
$ws_worker->onMessage = function($connection, $data) {  
    //显示数据  
    echo "you just received: $data\n";  
      
    //将数据插入到数据库  
    global $pdo;  
    $time = time();  
    $insert = "insert into chat_message(content, time, from_id, to_id) values('$data', $time, 1, 2)";  
      
    $pdo->exec($insert);  
      
    //向客户端回发数据  
    $connection->send("you just send: $data");  
};  
  
//运行worker  
$ws_worker->runAll();  
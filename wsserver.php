<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/29
 * Time: 22:10
 */

use Workerman\Worker;
require_once 'Workerman/Autoloader.php';

//����һ��Worker����127.0.0.1:8000, ʹ��websocketЭ��ͨѶ
$ws_worker = new Worker("websoket://127.0.0.1:8000");

//����4�����̶����ṩ����
$ws_worker->count = 4;

//��ʼ�����ݿ�����
/*
$dsn = "mysql:host=localhost;dbname=edu;port=3306";
$user = "root";
$pwd = "root";
$pdo = new PDO($dsn, $user, $pwd);
*/

//�����յ��ͻ��˷��������ݺ���ʾ���ݲ��ط����ͻ���
$ws_worker->onMessage = function($connection, $data){

    //��ʾ����
    echo  "you just received:$data\n ";

    //��ͻ��˻ط�����
    $connection->send("you just send:$data");

};

//����worker
$ws_worker->runAll();


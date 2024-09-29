<?php

require './vendor/autoload.php';

// 设置时区
date_default_timezone_set('PRC');

// 创建配置实例
$config = \Kafka\ProducerConfig::getInstance();
$config->setMetadataBrokerList('192.168.10.49:9092'); // 设置 Kafka 服务器地址
$config->setRequiredAck(1); // 确保消息被 leader 确认
$config->setIsAsyn(false); // 同步发送
$config->setProduceInterval(500); // 发送间隔
$config->setDebug('all'); // 启用调试

// 创建生产者实例
$producer = new \Kafka\Producer();

for ($i = 0; $i < 100; $i++) {
    try {
        // 发送消息
        $result = $producer->send([
            [
                'topic' => '1', // 确保该主题存在
                'value' => 'test' . $i,
            ],
        ]);

        if ($result) {
            echo "Message $i sent successfully.\n";
        } else {
            echo "Failed to send message $i.\n";
        }
    } catch (\Kafka\Exception $e) {
        echo "Error sending message $i: " . $e->getMessage() . "\n";
    }
}

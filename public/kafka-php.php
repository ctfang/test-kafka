<?php

require __DIR__.'/config.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


$logger = new Logger('my_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler("php://stdout", Logger::DEBUG));

$config = \Kafka\ProducerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList(KAFKA_BROKErS);
$config->setBrokerVersion(1);
$config->setRequiredAck(1);
$config->setIsAsyn(false);
$config->setProduceInterval(500);
$producer = new \Kafka\Producer();
$producer->setLogger($logger);

$result = $producer->send(array(
    array(
        'topic' => KAFKA_TOPIC_TEST,
        'value' => "tset",
        'key' => '',
    ),
));

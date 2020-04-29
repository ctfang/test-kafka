<?php

require_once __DIR__ . '/config.php';

$producer = new \RdKafka\Producer();
$producer->setLogLevel(LOG_DEBUG);

if ($producer->addBrokers(KAFKA_BROKErS) < 1) {
    echo "Failed adding brokers\n";
    exit;
}

$topic = $producer->newTopic(KAFKA_TOPIC_TEST);

if (!$producer->getMetadata(false, $topic, 2000)) {
    echo "Failed to get metadata, is broker down?\n";
    exit;
}

$topic->produce(RD_KAFKA_PARTITION_UA, 0, 123123123123);

echo "Message published\n";

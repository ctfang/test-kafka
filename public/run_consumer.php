<?php

require_once __DIR__ . '/config.php';


$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
//$conf->set('group.id', 'myConsumerGroup');

$kafka = new RdKafka\Consumer($conf);
$kafka->addBrokers(KAFKA_BROKErS);

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);

// Set the offset store method to 'file'
$topicConf->set('offset.store.method', 'file');
$topicConf->set('offset.store.path', sys_get_temp_dir());

$topicConf->set('auto.offset.reset', 'smallest');

$topic = $kafka->newTopic(KAFKA_TOPIC_TEST, $topicConf);

// Start consuming partition 0
$topic->consumeStart(KAFKA_PARTITION, RD_KAFKA_OFFSET_STORED);

while (true) {
    $message = $topic->consume(KAFKA_PARTITION, 120*10000);

    echo $message->payload,"\n";
}

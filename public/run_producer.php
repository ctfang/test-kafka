<?php

require_once __DIR__ . '/config.php';

$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
//$conf->set('group.id', 'myConsumerGroup');

$kafka = new RdKafka\Producer($conf);
$kafka->addBrokers(KAFKA_BROKErS);
//$kafka->setLogLevel(LOG_DEBUG);

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);

// Set the offset store method to 'file'
$topicConf->set('offset.store.method', 'file');
$topicConf->set('offset.store.path', sys_get_temp_dir());

$topicConf->set('auto.offset.reset', 'smallest');

$topic = $kafka->newTopic(KAFKA_TOPIC_TEST, $topicConf);


for ($i = 0; $i < 10; $i++) {
    $message = sprintf('Message %d', $i);
    $topic->produce(KAFKA_PARTITION, 0, $message);
    $kafka->poll(0);
}


while($kafka->getOutQLen() > 0) {
    $kafka->poll(0);
}


echo "OK ========= \n";
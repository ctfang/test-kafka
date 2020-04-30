<?php
require __DIR__.'/config.php';
//            $config = new \RdKafka\Conf();
//            $config->set('metadata.broker.list', 'ELK:9092');
//            $config->set('socket.timeout.ms', 0);
//            $config->set('queue.buffering.max.ms', 100);
//            $config->set('security.protocol', 'SASL_PLAINTEXT');
//            $config->set('sasl.mechanisms', 'PLAIN');
//            $config->set('sasl.username', 'kafka');
//            $config->set('sasl.password', '123456');
$topic_name = 'ouo_r1p1';
\Kafka\Protocol::init('1.0.0');
$provider = new \Kafka\Sasl\Plain('kafka', '124324');

$socket = new \Kafka\SocketSync('ELK-node1', '9092', null, $provider);

$socket->connect();
// {"required_ack":1,"timeout":5000,"data":{"test-2":{"partitions":[{"partition_id":0,"messages":["tset"]}],"topic_name":"test-2"}}}
$data = [
    'required_ack' => 0,
    'timeout' => '1000',
    'data' => [
        $topic_name => [
            'topic_name' => $topic_name,
            'partitions' => [
                [
                    'partition_id' => 0,
                    'messages' => json_encode(
                        [
                            "context" => [
                                "request_uid" => '',
                                "request_url" => '',
                                "request_os" => '',
                                "created_at" => date("Y-m-d H:i:s"),
                                "date" => date('Y-m-d'),
                                "env" => 'dev',
                                "request_data" => '',
                                "domain" => '',
                                "msg" => 'test sasl',
                                "request_method" => '',
                                "error_level" => 0,
                            ],
                            "level" => 200,
                            "level_name" => "INFO",
                        ]
                    ),
                ],
            ],
        ],
    ],
];


$requestData = \Kafka\Protocol::encode(\Kafka\Protocol::PRODUCE_REQUEST, $data);
$socket->write($requestData);
$dataLen = \Kafka\Protocol\Protocol::unpack(\Kafka\Protocol\Protocol::BIT_B32, $socket->readBlocking(4));
var_dump($dataLen);
$data = $socket->readBlocking($dataLen);
$correlationId = \Kafka\Protocol\Protocol::unpack(\Kafka\Protocol\Protocol::BIT_B32, substr($data, 0, 4));
$result = \Kafka\Protocol::decode(\Kafka\Protocol::PRODUCE_REQUEST, substr($data, 4));
var_dump($result);

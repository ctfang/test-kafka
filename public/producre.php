<?php

require_once __DIR__ . '/config.php';

$topic_name = "test";

$produce = new \PhpKafka\Protocol\Produce();


$header = $produce->encode("test");


\Kafka\Protocol::init('1.0.0');
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


$producePHP = new \Kafka\Protocol\Produce(1);
if ($producePHP->requestHeader($produce->requestId,0,0)==$header){
    die("信息头不一样");
}

$requestData = \Kafka\Protocol::encode(\Kafka\Protocol::PRODUCE_REQUEST, $data);


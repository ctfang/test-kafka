<?php
/**
 * Created by PhpStorm.
 * User: selden
 * Date: 2020-04-29
 * Time: 18:57
 */

namespace PhpKafka\Protocol;


use io\BinaryStringOutputStream;
use io\DataOutputStream;

class Produce
{
    public $apiVersion = 1;

    public $requestId = 0x00;

    public $clientId = 'kafka-php';

    public function encode()
    {
        $binaryOutputStream = new BinaryStringOutputStream();

        $header = $this->getHandel($binaryOutputStream,0x03);


    }

    public function getHandel(BinaryStringOutputStream $binaryOutputStream,$api)
    {
        $binaryPacketOutput = new DataOutputStream($binaryOutputStream);
        $binaryPacketOutput->writeUnSignedShortBE($api); // METADATA_REQUEST
        $binaryPacketOutput->writeUnSignedShortBE($this->apiVersion); // API_VERSION
        $binaryPacketOutput->writeUnSignedIntBE($this->requestId); // REQUEST_ID
        $binaryPacketOutput->writeUnSignedShortBE(strlen($this->clientId)); // CLIENT_ID length
        $binaryPacketOutput->writeString($this->clientId); // CLIENT_ID

        return $binaryPacketOutput;
    }
}
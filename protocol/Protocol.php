<?php
/**
 * Created by PhpStorm.
 * User: wecut
 * Date: 2020-05-06
 * Time: 09:53
 */

namespace PhpKafka\Protocol;


use io\BinaryStringOutputStream;
use io\DataOutputStream;

abstract class Protocol
{
    public $apiVersion = 1;

    public $requestId = 0x00;

    public $clientId = 'kafka-php';

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
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

/**
 * 信息生产者
 *
 * @package PhpKafka\Protocol
 */
class Produce extends Protocol
{
    /**
     * kafka api
     *
     * @var int
     */
    public $requestId = 0x00;

    /**
     * @param string $msg
     * @return string
     */
    public function encode(string $msg):string
    {
        $binaryOutputStream = new BinaryStringOutputStream();

        $header = $this->getHandel($binaryOutputStream,0x03);




        return $binaryOutputStream->toBinaryString();
    }
}
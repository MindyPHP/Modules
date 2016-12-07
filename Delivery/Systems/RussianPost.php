<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 25/05/15 10:48
 */

namespace Modules\Delivery\Systems;

use Mindy\Helper\Json;
use Modules\Delivery\Components\DeliverySystem;
use Modules\Delivery\Components\IDeliverySystem;

class RussianPost extends DeliverySystem implements IDeliverySystem
{
    public $host = 'api.postcalc.ru/';
    public $defaultPickup = [
        'cityZip' => 610000
    ];
    public $site = 'example.com';
    public $email = 'mail@mail.ru';

    public function getData($data = [])
    {
        $data = array_merge($data, ['c' => 'RU', 'o' => 'php', 'cs' => 'utf-8']);
        $url = 'http://' . $this->host . '?' . http_build_query($data);
        $options = array('http' =>
            array( 'header'  => 'Accept-Encoding: gzip','timeout' => 5, 'user_agent' => phpversion() )
        );

        if ($response = file_get_contents($url, false , stream_context_create($options)) ) {
            if ( substr($response,0,3) == "\x1f\x8b\x08" )  $response=gzinflate(substr($response,10,-8));
            $response = unserialize($response);
            if ( $response['Status'] == 'OK' && isset($response['Отправления'])) {
                return $response['Отправления'];
            } else {
                $this->debug("Error {$response['Status']}");
            };
        } else {
            $this->debug("Cannot connect to {$this->host}");
        }
        return null;
    }

    /**
     * @param $size - ['weight' => 1.4]
     * @param $place - ['cityZip' => '610000']
     * @param array $from - ['cityZip' => '610000']
     * @return null
     */
    public function count($size, $place, $from = [])
    {
        if (!$from) {
            $from = $this->defaultPickup;
        }
        if ($data = $this->getData(array_merge(['f' => $from['cityZip'], 't' => $place['cityZip']], ['w' => $size['weight'] * 1000]))) {
            return $data;
        }
        return null;
    }

    public function getCities()
    {
        return [];
    }
}

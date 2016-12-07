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

use Exception;
use Modules\Delivery\Components\DeliverySystem;
use Modules\Delivery\Components\IDeliverySystem;
use SoapClient;

class DPD extends DeliverySystem implements IDeliverySystem
{
    public $login = null;
    public $password = null;
    public $test = true;
    public $hosts = [
        'production' => 'ws.dpd.ru/services/',
        'test' => 'wstest.dpd.ru/services/'
    ];

    protected $services = [
        'getServiceCost' => 'calculator2',
        'getCitiesCashPay' => 'geography'
    ];
    protected $client;
    public $defaultPickup = [
        'cityId' => 195738501
    ];

    public function getHost($service = '')
    {
        $key = $this->test ? 'test' : 'production';
        return 'http://' . $this->hosts[$key] . $service . '?WSDL';
    }

    protected function connect($methodName)
    {
        if (isset($this->services[$methodName])) {
            $service = $this->services[$methodName];
            try {
                $this->client = new SoapClient($this->getHost($service));
            } catch (Exception $e) {
                $this->debug($e->getMessage());
                return false;
            }
            return true;
        }
        return false;
    }

    public function getData($methodName, $data = [], $isRequest = 0)
    {
        $request = array();

        if(!$this->connect($methodName)) return false;

        $data['auth'] = array(
            'clientNumber' => $this->login,
            'clientKey' => $this->password
        );

        if ($isRequest) {
            $request['request'] = $data;
        } else {
            $request = $data;
        }

        $obj = null;
        try {
            $obj = $this->client->$methodName($request);
            if (!$obj) {
                throw new Exception('Error');
            }
        } catch (Exception $e) {
            $this->debug($e->getMessage());
        }

        return $obj ?: null;
    }

    public function count($size, $place, $from = [])
    {
        $data['selfPickup'] = true;
        $data['selfDelivery'] = true;
        $data['delivery'] = $place;
        if (!$from) {
            $from = $this->defaultPickup;
        }
        $data['pickup'] = $from;
        $data['weight'] = $size['weight'];
        if (isset($size['size']) && isset($size['size']['height']) && isset($size['size']['width']) && isset($size['size']['depth']) &&
            $size['size']['height'] && $size['size']['width'] && $size['size']['depth']) {
            $data['volume'] = $size['size']['height'] * $size['size']['width'] * $size['size']['depth'] /  pow(10, 6);
        }
        $object = $this->getData('getServiceCost', $data, 1);
        return $this->toArray($object);
    }

    public function getCities()
    {
        $cities = $this->getData('getCitiesCashPay');
        return $this->toArray($cities);
    }

    public function toArray($object)
    {
        $data = json_decode(json_encode($object), true);
        return isset($data['return']) ? $data['return'] : $data;
    }

}
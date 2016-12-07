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

class EMS extends DeliverySystem implements IDeliverySystem
{
    public $host = 'emspost.ru/api/rest/';
    public $defaultPickup = [
        'cityId' => 'city--kirov'
    ];

    public function getHost($service = '')
    {
        $key = $this->test ? 'test' : 'production';
        return 'http://' . $this->hosts[$key] . $service . '?WSDL';
    }

    public function getData($methodName, $data = [])
    {
        $data['method'] = $methodName;
        $url = 'http://' . $this->host . '?' . http_build_query($data);
        $data = file_get_contents($url);
        if ($data) {
            $data = Json::decode($data);
            $data = $data['rsp'];
            if (isset($data['stat'])) unset($data['rsp']);
            return $data;
        }
        return null;
    }

    public function count($size, $place, $from = [])
    {
        if (!$from) {
            $from = $this->defaultPickup;
        }
        $data = $this->getData('ems.calculate', ['from' => $from['cityId'], 'to' => $place['cityId'], 'weight' => $size['weight']]);
        if (isset($data['price'])) {
            return $data['price'];
        }
        return null;
    }

    public function getCities()
    {
        return $this->getData('ems.get.locations', ['type' => 'cities', 'plain' => 'true']);
    }
}
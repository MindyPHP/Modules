<?php

/**
 * User: max
 * Date: 17/07/15
 * Time: 15:12
 */

namespace Modules\Geo\Middleware;

use Mindy\Base\Mindy;
use Mindy\Http\Request;
use Mindy\Middleware\Middleware\Middleware;
use Modules\Geo\Vendor\SxGeo;

class DetectCityMiddleware extends Middleware
{
    public function processRequest(Request $request)
    {
        $geo = $this->getIpDetails($_SERVER['REMOTE_ADDR']);
        if (isset($geo['city']) && !empty($geo['city'])) {
            $city = $geo['city'];
            $module = Mindy::app()->getModule('Geo');
            /** @var \Modules\Geo\GeoModule $module */
            $module->setCity($city['name_ru']);
        }
    }

    protected function getIpDetails($ipAddr)
    {
        $SxGeo = new SxGeo(__DIR__ . '/../data/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
        return $SxGeo->getCityFull($ipAddr);
    }
}

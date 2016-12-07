<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 14/11/14.11.2014 15:42
 */

namespace Modules\Geo;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class GeoModule extends Module
{
    private $_currentCity;

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('get_city', function () {
            return Mindy::app()->getModule('Geo')->getCity();
        });
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Country'),
                    'adminClass' => 'CountryAdmin'
                ],
                [
                    'name' => self::t('Region'),
                    'adminClass' => 'RegionAdmin'
                ],
                [
                    'name' => self::t('City'),
                    'adminClass' => 'CityAdmin'
                ],
            ]
        ];
    }

    public function setCity($city)
    {
        $this->_currentCity = $city;
    }

    public function getCity()
    {
        return $this->_currentCity;
    }
}

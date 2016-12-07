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
 * @date 28/08/14.08.2014 12:47
 */

namespace Modules\Offices\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\FloatField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

class Office extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name'),
                'required' => true,
            ],
            'description' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Description')
            ],
            'address' => [
                'class' => CharField::class,
                'verboseName' => self::t('Address'),
                'required' => true
            ],
            'contacts' => [
                'class' => TextField::class,
                'verboseName' => self::t('Contacts'),
                'null' => true
            ],
            'email' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Email')
            ],
            'phones' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Phone')
            ],
            'work_time' => [
                'class' => TextField::class,
                'verboseName' => self::t('Work time'),
                'null' => true,
            ],
            'lat' => [
                'class' => FloatField::class,
                'verboseName' => self::t('Latitude'),
                'null' => true
            ],
            'lng' => [
                'class' => FloatField::class,
                'verboseName' => self::t('Longitude'),
                'null' => true
            ],
            'position' => [
                'class' => IntField::class,
                'verboseName' => self::t('Position'),
                'editable' => false,
                'default' => 0,
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is published')
            ],
            'is_main' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is main')
            ],
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
                'verboseName' => self::t('Category')
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * Converts DMS ( Degrees / minutes / seconds ) to decimal format longitude / latitude
     * @param $deg
     * @param $min
     * @param $sec
     * @return mixed
     */
    protected function DMStoDEC($deg, $min, $sec)
    {
        return $deg + ((($min * 60) + ($sec)) / 3600);
    }

    /**
     * Converts decimal longitude / latitude to DMS ( Degrees / minutes / seconds )
     * This is the piece of code which may appear to
     * be inefficient, but to avoid issues with floating
     * point math we extract the integer part and the float
     * part by using a string function.
     *
     * @param $dec
     * @return array
     */
    protected function DECtoDMS($dec)
    {
        $vars = explode(".", $dec);
        $deg = $vars[0];
        $tempma = "0." . $vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = $tempma - ($min * 60);

        return ["deg" => $deg, "min" => $min, "sec" => $sec];
    }

    protected function convert($value)
    {
        return empty($value) ? null : strtr('deg°min′sec″', $this->DECtoDMS($value));
    }

    public function getLat_navitel()
    {
        return $this->convert($this->lat);
    }

    public function getLng_navitel()
    {
        return $this->convert($this->lng);
    }

    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            if ($owner->is_main) {
                self::objects()->update(['is_main' => false]);
            }
        }
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('office:view', ['id' => $this->id]);
    }
}

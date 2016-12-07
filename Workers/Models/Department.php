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
 * @date 13/11/14 10:03
 */
namespace Modules\Workers\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Model;
use Modules\Workers\WorkersModule;

class Department extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Department name'),
                'required' => true,
            ],
            'position' => [
                'class' => IntField::className(),
                'verboseName' => WorkersModule::t('Position'),
                'null' => true,
                'editable' => false,
                'default' => 0
            ],
            'workers' => [
                'class' => HasManyField::className(),
                'modelClass' => Worker::className(),
                'relatedName' => 'department',
                'null' => true,
                'editable' => false
            ],
            'staff' => [
                'class' => ManyToManyField::className(),
                'modelClass' => Worker::className(),
                'null' => true,
                'editable' => false
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('workers.list');
    }
} 
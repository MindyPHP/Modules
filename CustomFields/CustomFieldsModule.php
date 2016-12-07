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
 * @date 24/03/15 09:19
 */
namespace Modules\CustomFields;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Admin\Traits\AutoAdminTrait;

class CustomFieldsModule extends Module
{
    use AutoAdminTrait;

    public $model = null;

    public static function preConfigure()
    {
        Mindy::app()->signal->handler('\Mindy\Orm\Model', 'afterDelete', [self::className(), 'afterDeleteModel']);
        Mindy::app()->signal->handler('\Mindy\Orm\Model', 'afterSave', [self::className(), 'afterSaveModel']);
    }

    public static function afterDeleteModel($owner)
    {
        $module = Mindy::app()->getModule('CustomFields');
        if ($module && $module->model && $owner->className() == $module->model) {
            $owner->clearCustom();
        }
    }

    public static function afterSaveModel($owner, $isNew)
    {
        $module = Mindy::app()->getModule('CustomFields');
        if ($module && $module->model && $owner->className() == $module->model) {
            $owner->checkCustomData();
        }
    }
}
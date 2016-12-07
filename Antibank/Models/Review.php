<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 15/09/14
 * Time: 14:49
 */

namespace Modules\Antibank\Models;

use Mindy\Base\Mindy;
use Modules\Reviews\Models\Review as MindyReview;
use Mindy\Orm\Fields\CharField;

class Review extends MindyReview
{
    public static function getFields()
    {
        $parentFields = parent::getFields();
        $parentFields['city'] = [
            'class' => CharField::className(),
            'verboseName' => 'Город',
            'required' => true
        ];
        $parentFields['content']['required'] = true;
        return $parentFields;
    }

    public static function getModuleName()
    {
        return 'Reviews';
    }

    public function getModule()
    {
        return Mindy::app()->getModule('Reviews');
    }
} 
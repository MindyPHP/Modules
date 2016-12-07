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
 * @date 15/09/14.09.2014 15:11
 */

namespace Modules\Solutions\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\FileField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Solutions\SolutionsModule;

class Solution extends Model
{
    const STATUS_COMPLETE = 1;
    const STATUS_SUCCESS = 2;

    public static function getFields()
    {
        return [
            'region' => [
                'class' => ForeignField::className(),
                'modelClass' => Region::className(),
                'required' => true,
                'verboseName' => SolutionsModule::t('Region')
            ],
            'bank' => [
                'class' => ForeignField::className(),
                'modelClass' => Bank::className(),
                'required' => true,
                'verboseName' => SolutionsModule::t('Bank')
            ],
            'court' => [
                'class' => CharField::className(),
                'verboseName' => SolutionsModule::t('Court')
            ],
            'question' => [
                'class' => CharField::className(),
                'verboseName' => SolutionsModule::t('Question')
            ],
            'result' => [
                'class' => CharField::className(),
                'verboseName' => SolutionsModule::t('Result')
            ],
            'document' => [
                'class' => FileField::className(),
                'verboseName' => SolutionsModule::t('Document'),
            ],
            'content' => [
                'class' => TextField::className(),
                'verboseName' => SolutionsModule::t('Content')
            ],
            'status' => [
                'class' => IntField::className(),
                'verboseName' => SolutionsModule::t('Status'),
                'choices' => [
                    self::STATUS_SUCCESS => SolutionsModule::t('Successful'),
                    self::STATUS_COMPLETE => SolutionsModule::t('Complete')
                ]
            ],
            'comments' => [
                'class' => HasManyField::className(),
                'modelClass' => Comment::className()
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true
            ]
        ];
    }

    public function __toString()
    {
        return (string) $this->bank;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('solutions.view', ['pk' => $this->pk]);
    }

    public function getIsComplete()
    {
        return self::STATUS_COMPLETE == $this->status;
    }
}

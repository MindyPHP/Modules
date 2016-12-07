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
 * @date 19/11/14 08:11
 */
namespace Modules\Workers\Models;

use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Workers\WorkersModule;

/**
 * Class Review
 * @package Modules\Workers\Models
 * @method static \Mindy\Orm\Manager published($instance = null)
 */
class Review extends Model
{
    const STATUS_MODERATION = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_DECLINED = 3;

    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Review name'),
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Phone'),
                'null' => true
            ],
            'video' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Review video'),
                'null' => true
            ],
            'description' => [
                'class' => TextField::className(),
                'verboseName' => WorkersModule::t('Review text'),
                'null' => true
            ],
            'why' => [
                'class' => TextField::className(),
                'verboseName' => WorkersModule::t('Why our company?'),
                'null' => true
            ],
            'recommendations' => [
                'class' => TextField::className(),
                'verboseName' => WorkersModule::t('Your recommendations?'),
                'null' => true
            ],
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => WorkersModule::t('Review image'),
                'sizes' => [
                    'preview' => [
                        306, 170,
                        'method' => 'resize'
                    ]
                ]
            ],
            'date' => [
                'class' => DateField::className(),
                'verboseName' => WorkersModule::t('Review date'),
                'null' => true,
            ],
            'worker' => [
                'class' => ForeignField::className(),
                'modelClass' => Worker::className(),
                'verboseName' => WorkersModule::t('Worker'),
                'null' => true
            ],
            'status' => [
                'class' => IntField::className(),
                'verboseName' => WorkersModule::t('Review status'),
                'default' => self::STATUS_MODERATION,
                'choices' => [
                    self::STATUS_MODERATION => WorkersModule::t('Moderation'),
                    self::STATUS_PUBLISHED => WorkersModule::t('Published'),
                    self::STATUS_DECLINED => WorkersModule::t('Declined')
                ]
            ]
        ];
    }

    public static function publishedManager($instance = null)
    {
        $className = get_called_class();
        return new ReviewPublishedManager($instance ? $instance : new $className);
    }

    public function getVideoReview()
    {
        if (preg_match('/(youtube\.com|youtu\.be|youtube-nocookie\.com)\/(watch\?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*)).*/', $this->video, $matches)){
            $code = $matches[3];
            return "http://img.youtube.com/vi/$code/0.jpg";
        }
    }

    public function beforeSave($owner, $isNew)
    {
        if (!$owner->date) {
            $owner->date = date('Y-m-d');
        }

        if (!$owner->status) {
            $owner->status = self::STATUS_MODERATION;
        }
    }

    public function __toString() 
    {
        return (string)$this->name;
    }
} 
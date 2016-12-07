<?php

namespace Modules\Reviews;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class ReviewsModule extends Module
{
    public $enableForm = true;
    public $modelClass = '\Modules\Reviews\Models\Review';
    public $formClass = '\Modules\Reviews\Forms\ReviewUserForm';
    public $formAdminClass = '\Modules\Reviews\Forms\ReviewAdminForm';

    public function getVersion()
    {
        return '1.0';
    }

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('get_reviews', function($limit = 10, $order = '-published_at') {
            $cls = Mindy::app()->getModule('Reviews')->modelClass;
            return $cls::objects()
                ->filter(['is_published' => true])
                ->offset(0)
                ->limit($limit)
                ->order([$order])
                ->all();
        });
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Reviews'),
                    'adminClass' => 'ReviewsAdmin'
                ]
            ]
        ];
    }
}

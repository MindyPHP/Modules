<?php

namespace Modules\Blog;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class BlogModule extends Module
{
    public $enableComments;
    public $commentForm;

    public function init()
    {
        if ($this->enableComments === null) {
            $this->enableComments = Mindy::app()->hasModule('Comments');
        }
    }

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('get_blog_pages', function ($parentId, $limit = 10, $offset = 0) {
            return \Modules\Blog\Models\Post::objects()->filter([
                'parent_id' => $parentId
            ])->limit($limit)->offset($offset)->all();
        });
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Posts'),
                    'adminClass' => 'PostAdmin',
                ],
                [
                    'name' => self::t('Categories'),
                    'adminClass' => 'CategoryAdmin',
                ],
                [
                    'name' => self::t('Comments'),
                    'adminClass' => 'CommentAdmin',
                ]
            ]
        ];
    }
}

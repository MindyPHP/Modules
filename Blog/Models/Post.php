<?php

namespace Modules\Blog\Models;

use Closure;
use Mindy\Base\Mindy;
use Mindy\Helper\Alias;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Mindy\Query\ConnectionManager;
use Modules\Blog\BlogModule;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class Post
 * @package Modules\Blog
 * @method static \Modules\Blog\Models\PostManager objects($instance = null)
 */
class Post extends Model
{
    public $metaConfig = [
        'title' => 'name',
        'keywords' => 'content',
        'description' => 'content_short'
    ];

    /**
     * Prefix for cache
     */
    const CACHE_PREFIX = 'pages_';

    public static function getFields()
    {
        $fields = [
            'name' => [
                'class' => CharField::class,
                'required' => true,
                'verboseName' => self::t('Name')
            ],
            'slug' => [
                'class' => SlugField::class,
                'verboseName' => self::t('Slug'),
                'unique' => true
            ],
            'content' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Content')
            ],
            'content_short' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Short content')
            ],
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
                'null' => false,
                'verboseName' => self::t('Category')
            ],
            'file' => [
                'class' => ImageField::class,
                'null' => true,
                'sizes' => [
                    'thumb' => [
                        160, 104,
                        'method' => 'adaptiveResizeFromTop',
                        'options' => ['jpeg_quality' => 5]
                    ],
                    'resize' => [
                        978
                    ],
                ],
                'verboseName' => self::t('File'),
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'verboseName' => self::t('Created at'),
                'editable' => false
            ],
            'updated_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
                'editable' => false
            ],
            'published_at' => [
                'class' => DateTimeField::class,
                'null' => true,
                'verboseName' => self::t('Published at'),
            ],
            'view' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('View')
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is published'),
                'default' => true
            ],
            'enable_comments' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Enable comments'),
                'default' => true
            ],
            'enable_comments_form' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Enable comments form'),
                'default' => true
            ],
        ];

        $app = Mindy::app();
        if ($app->hasModule('Comments') && $app->getModule('Blog')->enableComments) {
            $fields['comments'] = [
                'class' => HasManyField::class,
                'modelClass' => Comment::class
            ];
        }
        return $fields;
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new PostManager($instance ? $instance : new $className);
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * Get available views
     * @return array
     */
    public function getViews()
    {
        $finder = Mindy::app()->getComponent('finder');
        $theme = $finder->theme;
        if ($theme instanceof Closure) {
            $theme = $theme->__invoke();
        }
        $pathApp = Alias::get($theme ? 'application.themes.' . $theme . '.templates.blog' : 'application.templates.blog');
        $pathModule = Alias::get('blog.templates.blog');

        $templates_app = $this->getTemplates($pathApp);
        $templates_module = $this->getTemplates($pathModule);

        $templates = [null => ''];
        foreach ($templates_app as $template) {
            $templates[$template] = $template;
        }
        foreach ($templates_module as $template) {
            $templates[$template] = $template;
        }

        return $templates;
    }

    /**
     * Get templates
     * @param $dir
     * @return array
     */
    public function getTemplates($dir)
    {
        if (!is_dir($dir)) {
            return [];
        }

        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        $files = [];
        while ($it->valid()) {
            if (!$it->isDot() && substr($it->getSubPathName(), 0, 1) !== '_') {
                $files[] = $it->getSubPathName();
            }
            $it->next();
        }
        return $files;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('blog:view', ['pk' => $this->pk, 'slug' => $this->slug]);
    }

    public function beforeSave($owner, $isNew)
    {
        if ($owner->is_published) {
            $queryBuilder = ConnectionManager::getDb()->getQueryBuilder();
            /** @var \Mindy\Query\Pgsql\Lookup|\Mindy\Query\Mysql\Lookup $queryBuilder */

            if (empty($owner->published_at)) {
                $owner->published_at = $queryBuilder->convertToDateTime();
            } else {
                $owner->published_at = $queryBuilder->convertToDateTime($owner->published_at);
            }
        }
    }

    public function getAdminNames($instance = null)
    {
        $module = $this->getModule();
        if ($instance) {
            $updateTranslate = $module->t('Update blog post: {name}', ['{name}' => (string)$instance]);
        } else {
            $updateTranslate = $module->t('Update blog post');
        }
        return [
            $module->t('Blog posts'),
            $module->t('Create blog post'),
            $updateTranslate,
        ];
    }
}

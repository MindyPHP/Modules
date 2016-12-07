<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 02/03/16
 * Time: 14:06
 */

namespace Modules\Pages\Models;

use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Mindy\Query\ConnectionManager;

abstract class BaseFlatPage extends Model
{
    public $metaConfig = [
        'title' => 'name',
        'keywords' => 'content',
        'description' => 'content_short'
    ];

    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'required' => true,
                'verboseName' => self::t('Name')
            ],
            'url' => [
                'class' => SlugField::class,
                'source' => 'name',
                'verboseName' => self::t('Url'),
                'unique' => true
            ],
            'content_short' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Short content')
            ],
            'content' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Content')
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'verboseName' => self::t("Created at"),
                'editable' => false,
            ],
            'updated_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
                'verboseName' => self::t("Updated at"),
                'editable' => false,
            ],
            'published_at' => [
                'class' => DateTimeField::class,
                'null' => true,
                'verboseName' => self::t("Published at")
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is published'),
                'default' => true
            ],
        ];
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new FlatPageManager($instance ? $instance : new $className);
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * @param \Modules\Pages\Models\Page $owner
     * @param bool $isNew
     */
    public function beforeSave($owner, $isNew)
    {
        $queryBuilder = ConnectionManager::getDb()->getQueryBuilder();
        /** @var \Mindy\Query\Pgsql\Lookup|\Mindy\Query\Mysql\Lookup $queryBuilder */

        if (empty($owner->published_at)) {
            $owner->published_at = $queryBuilder->convertToDateTime();
        } else {
            $owner->published_at = $queryBuilder->convertToDateTime($owner->published_at);
        }
    }
}
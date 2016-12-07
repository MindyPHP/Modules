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
 * @date 09/09/14.09.2014 09:40
 */

namespace Modules\Video\Models;

use MediaEmbed\MediaEmbed;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Video\VideoModule;

/**
 * Class Video
 * @package Modules\Video\Models
 * @property string thumbnail
 */
class Video extends Model
{
    private $_video;

    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'required' => true,
                'verboseName' => self::t('Name')
            ],
            'description' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Description')
            ],
            'html' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Html')
            ],
            'url' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Video url')
            ],
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
                'verboseName' => self::t('Category')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function beforeSave($owner, $isNew)
    {
        $owner->html = $this->getEmbedCode([]);
    }

    public function __get($name)
    {
        if (strpos($name, 'video') === 0) {
            if (strpos($name, 'x') !== false) {
                $data = explode('x', str_replace('video_', '', $name));
                list($width, $height) = $data;
                $options = [
                    'width' => $width,
                    'height' => $height
                ];
            } else {
                $options = [];
            }
            return $this->getEmbedCode($options);
        }
        return parent::__get($name);
    }

    protected function initVideo()
    {
        if ($this->_video === null) {
            $this->_video = (new MediaEmbed())->parseUrl($this->url);
        }
        return $this->_video;
    }

    public function getEmbedCode($options = [])
    {
        return $this->initVideo()->setAttribute($options)->getEmbedCode();
    }

    public function getThumbnail()
    {
        return $this->initVideo()->getImageSrc();
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('video:view', ['id' => $this->id]);
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = self::t('Video');
        return $names;
    }
}

<?php

namespace Modules\Meta\Helpers;

use Mindy\Base\ErrorHandler;
use Mindy\Base\Mindy;
use Mindy\Helper\Creator;
use Mindy\Helper\Traits\RenderTrait;
use Modules\Core\Controllers\Controller;
use Modules\Meta\Components\MetaTrait;
use Modules\Meta\Models\Meta;

class MetaHelper
{
    use RenderTrait;

    public static function getMeta($controller, $canonical = null)
    {
        if ($controller instanceof ErrorHandler) {
            return;
        }

        $uri = Mindy::app()->request->http->requestUri;
        $meta = self::fetchMeta($uri);

        if ($meta === null && ($pos = strpos($uri, '?')) !== false) {
            // Remove query params from uri
            $meta = self::fetchMeta(substr($uri, 0, $pos));
        }

        $site = null;
        if (Mindy::app()->getModule('Meta')->onSite) {
            $site = Mindy::app()->getModule('Sites')->getSite();
        }
        $title = self::formatTitle($controller, $meta ? $meta->title : null, $site);

        if ($meta) {
            echo self::renderTemplate('meta/meta_helper.html', [
                'title' => $title,
                'canonical' => $canonical,
                'description' => $meta->description,
                'keywords' => $meta->keywords,
                'site' => $site
            ]);
        } else {
            echo self::renderTemplate('meta/meta_helper.html', [
                'title' => $title,
                'canonical' => $canonical,
                'site' => $site
            ]);
        }
    }

    /**
     * @param $controller
     * @param null $title
     * @param $site
     * @return string
     */
    protected static function formatTitle($controller, $title = null, $site)
    {
        $data = [];
        if ($controller instanceof Controller) {
            if (array_key_exists(MetaTrait::class, Creator::class_uses_deep($controller))) {
                foreach ($controller->getTitle() as $title) {
                    $data[] = $title;
                }
            } else if ($title) {
                $data[] = $title;
            }
        }

        $data[] = $site ? (string)$site : Mindy::app()->name;
        return implode(' - ', $data);
    }

    protected static function fetchMeta($uri)
    {
        $qs = Meta::objects()->filter(['url' => $uri]);
        if (Mindy::app()->getModule('Meta')->onSite) {
            $qs = $qs->currentSite();
        }
        return $qs->limit(1)->get();
    }
} 
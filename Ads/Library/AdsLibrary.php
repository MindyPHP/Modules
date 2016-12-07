<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 24/02/16
 * Time: 16:39
 */

namespace Modules\Ads\Library;

use Mindy\Template\Library;
use Modules\Ads\Models\Ad;

class AdsLibrary extends Library
{
    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'get_ads' => function ($slug) {
                return Ad::objects()->filter(['block__slug' => $slug])->all();
            }
        ];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return [];
    }
}
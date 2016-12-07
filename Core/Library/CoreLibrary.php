<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 18/02/16
 * Time: 12:26
 */

namespace Modules\Core\Library;

use Mindy\Base\Mindy;
use Mindy\Helper\Alias;
use Mindy\Helper\Json;
use Mindy\Locale\Translate;
use Mindy\Template\Expression\ArrayExpression;
use Mindy\Template\Library;
use Mindy\Template\Node\ImageNode;
use Mindy\Template\Token;

class CoreLibrary extends Library
{
    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'basename' => 'basename',
            'strtok' => 'strtok',
            'locale' => function () {
                return Mindy::app()->locale;
            },
            'locale_date' => function ($timestamp, $format = 'd MMMM yyyy') {
                return Translate::getInstance()->getDateFormatter()->format($format, $timestamp);
            },
            'method_exists' => function ($obj, $name) {
                return method_exists($obj, $name);
            },
            'd' => 'd',
            'is_file' => 'is_file',
            'time' => 'time',
            'strtotime' => 'strtotime',
            't' => function ($text, $category, $params = []) {
                if ($category !== 'app' && !strpos($category, '.')) {
                    $category .= '.main';
                }
                $findCategory = explode('.', $category);
                $moduleNameRaw = ucfirst($findCategory[0]);
                if (Mindy::app()->hasModule($moduleNameRaw)) {
                    $module = Mindy::app()->getModule($moduleNameRaw);
                    $moduleName = get_class($module) . '.' . $findCategory[1];
                    return Mindy::t($moduleName, $text, $params);
                } else {
                    return $text;
                }
            },
            'get_static_version' => function () {
                $filePath = Alias::get('www.static') . '/package.json';
                $content = file_get_contents($filePath);
                $data = JSON::decode($content);
                return $data['version'];
            },
            'base64_encode' => 'base64_encode',
            'base64_decode' => 'base64_decode',
            'csrf_token' => function () {
                return Mindy::app()->request->csrf->getValue();
            },
            'ucfirst' => ['\Mindy\Helper\Text', 'mbUcfirst'],
            'param' => ['\Modules\Core\Components\ParamsHelper', 'get'],
            'humanizeDateTime' => ['\Modules\Core\Components\Humanize', 'humanizeDateTime'],
            'humanizeSize' => ['\Modules\Core\Components\Humanize', 'humanizeSize'],
            'humanizePrice' => ['\Modules\Core\Components\Humanize', 'numToStr'],
            'limit' => ['\Mindy\Helper\Text', 'limit'],
        ];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return [
//            'image_new' => 'parseImage',
        ];
    }
}
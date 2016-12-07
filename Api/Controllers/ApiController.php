<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/07/14.07.2014 18:50
 */

namespace Modules\Api\Controllers;

use Mindy\Base\Mindy;
use Mindy\Helper\Json;
use Mindy\Helper\Xml;
use Modules\Core\Controllers\CoreController;

class ApiController extends CoreController
{
    public $defaultFormat = 'json';
    /**
     * @void
     */
    public function actionIndex()
    {
        $format = $this->getFormat();
        $app = Mindy::app();
        $apiList = $app->getModule('Api')->getApi();
        $response = [];
        foreach ($apiList as $name => $api) {
            $response[$name] = $app->request->http->absoluteUrl($app->urlManager->reverse('api.list', [
                'name' => $name,
                'format' => $format
            ]));
        }
        echo $this->encode($response, $format);
    }

    /**
     * @param $name
     * @return \Modules\Api\Components\Api
     * @void
     */
    protected function getApi($name)
    {
        $api = Mindy::app()->getModule('Api')->getApiList();
        return isset($api[$name]) ? $api[$name] : null;
    }

    /**
     * @param $format
     */
    public function notFound($format)
    {
        echo $this->encode([
            'error' => $this->errorMessage(404)
        ], $format);
        Mindy::app()->end();
    }

    /**
     * @param $name
     */
    public function actionList($name)
    {
        $format = $this->getFormat();
        $api = $this->getApi($name);
        if ($api === null) {
            $this->notFound($format);
        }
        echo $this->encode($api->internalList($api), $format);
    }

    /**
     * @param $name
     * @param $pk
     */
    public function actionView($name, $pk)
    {
        $format = $this->getFormat();
        $api = $this->getApi($name, $format);
        if ($api === null) {
            $this->notFound($format);
        }
        $data = $api->internalDetail($api, $pk);
        if ($data === null) {
            $this->notFound($format);
        }
        echo $this->encode($data, $format);
    }

    /**
     * @param $name
     * @param $action
     */
    public function actionCustom($name, $action)
    {
        $format = $this->getFormat();
        $api = $this->getApi($name, $format);
        if ($api === null) {
            $this->notFound($format);
        }
        if (method_exists($api, $action)) {
            echo $this->encode(call_user_func([$api, $action]), $format);
        } else {
            $this->notFound($format);
        }
    }

    /**
     * @param $data
     * @param $format
     * @return string
     */
    public function encode($data, $format)
    {
        $charset = Mindy::app()->charset;
        $format = str_replace('.', '', $format);
        switch ($format) {
            case ".xml":
                header('Content-Type: text/xml; charset=' . $charset);
                return Xml::encode('response', $data);
            case ".json":
            default:
                header('Content-Type: application/json; charset=' . $charset);
                return Json::encode($data);
        }
    }

    private function getFormat()
    {
        return isset($_GET['format']) ? $_GET['format'] : $this->defaultFormat;
    }
}

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
 * @date 05/10/14.10.2014 21:45
 */

namespace Modules\Api\Components;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Orm\Manager;
use Mindy\Orm\Model;
use Mindy\Orm\QuerySet;
use Mindy\Pagination\Pagination;

abstract class Api
{
    use Accessors, Configurator;

    /**
     * @var array
     */
    public $pagerSettings = [
        'name' => 'page'
    ];
    /**
     * @var string
     */
    public $slug = 'pk';

    /**
     * @return \Mindy\Orm\Model|\Mindy\Orm\TreeModel
     */
    abstract public function getModel();

    /**
     * @return \Mindy\Orm\Manager|\Mindy\Orm\QuerySet
     */
    public function getQuerySet()
    {
        return $this->getModel()->objects();
    }

    /**
     * TODO нужны методы fetchRelated которые будут сразу возвращать в массиве нужную модель или массив
     * @param $model
     * @param array $fields
     * @return mixed
     */
    public function hydrateItem(&$model, array $fields)
    {
        $data = $model->toArray();
        if (!empty($fields)) {
            $fetch = array_diff($fields, array_keys($data));
            $unset = array_diff(array_keys($data), $fields);
            foreach ($unset as $unsetField) {
                unset($data[$unsetField]);
            }
            foreach ($fetch as $fetchField) {
                $value = $model->$fetchField;
                if ($value instanceof Model) {
                    $value = $value->toArray();
                } else if ($value instanceof Manager || $value instanceof QuerySet) {
                    $value = $value->asArray()->all();
                }
                $data[$fetchField] = $value;
            }
        }
        if (method_exists($model, 'getAbsoluteUrl')) {
            $data['absoluteUrl'] = $model->getAbsoluteUrl();
        }
        return $data;
    }

    public function getAllowedFields()
    {
        return array_keys($this->getModel()->getFieldsInit());
    }

    public function allowedFields(array $data)
    {
        $result = [];
        // TODO receive primary key name from "pk"
        $fields = $this->getAllowedFields();
        foreach ($data as $item) {
            $result[] = $this->hydrateItem($item, $fields);
        }
        return $result;
    }

    /**
     * @param $api \Modules\Api\Components\Api
     * @param $pk int
     * @return array
     */
    public function internalDetail($api, $pk)
    {
        $item = $api->getQuerySet()->filter([$this->slug => $pk])->get();
        if ($item === null) {
            return null;
        }
        return $api->hydrateItem($item, $api->getAllowedFields());
    }

    protected function getFilterParams()
    {
        $filter = $_GET;
        unset($filter['format']);
        unset($filter[$this->pagerSettings['name']]);
        unset($filter['name']);
        unset($filter['order']);
        unset($filter['pageSize']);
        return $filter;
    }

    protected function getOrderParams()
    {
        return isset($_GET['order']) ? $_GET['order'] : null;
    }

    /**
     * @param $api \Modules\Api\Components\Api
     * @return array
     */
    public function internalList($api)
    {
        sleep(1);
        $filter = $this->getFilterParams();
        $order = $this->getOrderParams();
        $qs = $api->getQuerySet();

        if (!empty($filter)) {
            $qs = $qs->filter($filter);
        }
        if ($order) {
            $qs = $qs->order([$order]);
        }
        $pagerSettings = isset($_GET['pageSize']) ? array_merge($this->pagerSettings, ['pageSize' => $_GET['pageSize']]) : $this->pagerSettings;
        $pager = new Pagination($qs, $pagerSettings);
        $pager->paginate();
        $pager->data = $api->allowedFields($pager->data);
        return $pager->toJson();
    }
}

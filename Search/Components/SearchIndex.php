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
 * @date 11/11/14.11.2014 10:43
 */

namespace Modules\Search\Components;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Orm\Model;

abstract class SearchIndex
{
    use Accessors, Configurator;

    public $fields = [];

    /**
     * @return array
     */
    abstract public function getParams();

    /**
     * @return array
     */
    public function getProperties()
    {
        return [];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    abstract public function getModel();

    public function getQuerySet()
    {
        $fields = array_merge([$this->getModel()->getPkName()], $this->fields);
        return $this->getModel()->objects()->valuesList($fields);
    }

    public function fromModel(Model $model)
    {
        $data = [];
        foreach($this->fields as $field) {
            $data[$field] = $model->getField($field)->getValue();
        }
        return [$model->pk, $data];
    }
}

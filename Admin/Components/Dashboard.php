<?php

/**
 * User: max
 * Date: 22/07/15
 * Time: 14:54
 */

namespace Modules\Admin\Components;

use Mindy\Helper\Traits\RenderTrait;

abstract class Dashboard
{
    use RenderTrait;

    abstract public function getTemplate();

    public function __toString()
    {
        return (string)$this->render();
    }

    public function getColumns()
    {
        return ['small-12', 'medium-12', 'large-6'];
    }

    public function getData()
    {
        return [

        ];
    }

    public function render()
    {
        return $this->renderTemplate($this->getTemplate(), $this->getData());
    }
}

<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 31/01/15 17:25
 */

namespace Modules\Admin\Tables;

use Closure;
use Exception;
use Mindy\Base\Mindy;

class AdminLinkColumn extends AdminRawColumn
{
    /**
     * @var \Modules\Admin\Components\ModelAdmin|\Modules\Admin\Components\NestedAdmin
     */
    public $admin;
    /**
     * @var string
     */
    public $headCellTemplate = '<th {html}>{title}</th>';
    /**
     * @var string
     */
    public $currentOrder;
    /**
     * @var string
     */
    public $moduleName;

    /**
     * @var string
     */
    public $template = "<a href='{url}' title='{value}'>{text}</a>";
    /**
     * @var Closure
     */
    public $route;

    public $text;

    /**
     * @param $record
     * @return string
     * @throws \Exception
     */
    public function getValue($record)
    {
        $value = parent::getValue($record);
        $text = $this->text;
        if (!empty($text) && $text instanceof Closure) {
            $text = $text($value);
        } else {
            $text = $value;
        }
        if (empty($this->route)) {
            throw new Exception('Missing route');
        }
        $url = $this->route->__invoke($record);
        return $url ? strtr($this->template, [
            '{value}' => $value,
            '{text}' => $text,
            '{url}' => $url
        ]) : $value;
    }

    public function renderHeadCell()
    {
        $title = $this->getTitle();
        $classes = ['th-' . $this->name];
        $orderColumn = $this->admin->orderColumn($this->name);
        if ($orderColumn) {
            if ($this->currentOrder == $orderColumn) {
                $class[] = 'desc';
                $orderColumn = '-' . $orderColumn;
            } else {
                $class[] = 'asc';
            }

            $request = Mindy::app()->request;
            $urlManager = Mindy::app()->urlManager;
            $title = strtr('<a href="{url}?order={order}&search={search}&id={id}">{title}</a>', [
                '{title}' => $title,
                '{url}' => $urlManager->reverse('admin:list', [
                    'moduleName' => $this->moduleName,
                    'adminClass' => $this->admin->classNameShort()
                ]),
                '{order}' => $orderColumn,
                '{search}' => $request->getParam('search'),
                '{id}' => $request->getParam('id'),
            ]);
        }
        return strtr($this->headCellTemplate, [
            '{title}' => $title,
            '{html}' => $this->formatHtmlAttributes([
                'class' => implode(' ', $classes)
            ])
        ]);
    }
}

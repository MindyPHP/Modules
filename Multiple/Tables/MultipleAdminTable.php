<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 30/01/15 11:14
 */

namespace Modules\Multiple\Tables;

use Modules\Admin\Tables\AdminTable;

class MultipleAdminTable extends AdminTable
{
    public $html = [
        'data-toggle' => 'checkboxes',
        'data-range' => 'true'
    ];

    public function init()
    {
        parent::init();

        $this->html = array_merge($this->html, [
            'class' => $this->sortingColumn ? 'sortingColumn multiple-table' : 'multiple-table'
        ]);
    }
}

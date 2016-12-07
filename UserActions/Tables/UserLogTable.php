<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/01/15 18:16
 */

namespace Modules\UserActions\Tables;

use Mindy\Table\Columns\RawColumn;
use Mindy\Table\Table;
use Modules\UserActions\UserActionsModule;

class UserLogTable extends Table
{
    public function getColumns()
    {
        return [
            'created_at' => [
                'class' => RawColumn::className(),
                'title' => UserActionsModule::t('Created at')
            ],
            'message' => [
                'class' => RawColumn::className(),
                'title' => UserActionsModule::t('Message')
            ],
            'ip' => [
                'class' => RawColumn::className(),
                'title' => UserActionsModule::t('Ip')
            ],
        ];
    }

    public function render()
    {
        return strtr($this->template, [
            '{html}' => $this->getHtmlAttributes(),
            '{caption}' => $this->renderCaption(),
            '{header}' => $this->renderHeader(),
            '{footer}' => $this->renderFooter(),
            '{body}' => $this->renderBody(),
            '{pager}' => $this->getPager()->render('admin/admin/_pager.html')
        ]);
    }
}

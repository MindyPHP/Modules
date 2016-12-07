<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 02/03/16
 * Time: 14:20
 */

namespace Modules\Pages\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Pages\Forms\FlatPageForm;

abstract class BaseFlatPageAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }

    public function getSearchFields()
    {
        return ['name', 'id'];
    }

    public function getCreateForm()
    {
        return FlatPageForm::class;
    }
}
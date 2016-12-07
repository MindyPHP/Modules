<?php

namespace Modules\Pages\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Pages\Forms\BlockForm;
use Modules\Pages\Models\Block;

/**
 * Class BlockAdmin
 * @package Modules\User
 */
class BlockAdmin extends Admin
{
    public $columns = ['slug', 'name'];

    public function getCreateForm()
    {
        return BlockForm::class;
    }

    public function getModelClass()
    {
        return Block::class;
    }
}


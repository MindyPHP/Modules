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
 * @date 14/10/14.10.2014 17:36
 */

namespace Modules\Forum\Admin;

use Modules\Admin\Components\NestedAdmin;
use Modules\Forum\Forms\ForumForm;
use Modules\Forum\Models\Forum;

class ForumAdmin extends NestedAdmin
{
    public function getColumns()
    {
        return ['name', 'is_sticky', 'is_closed', 'topics_count', 'replies_count'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Forum;
    }

    public function getCreateForm()
    {
        return ForumForm::className();
    }
}

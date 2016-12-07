<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 19/04/16
 * Time: 17:32
 */

namespace Modules\Feedback\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Feedback\Models\BackCall;

class BackCallAdmin extends Admin
{
    public $permissions = [
        'create' => false,
        'update' => false,
        'remove' => false
    ];

    public $columns = ['name', 'phone', 'created_at'];

    public function getActions()
    {
        return ['info'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return BackCall::class;
    }
}
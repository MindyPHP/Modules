<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 15/04/16
 * Time: 20:30
 */

namespace Modules\Feedback\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Feedback\Models\Feedback;

class FeedbackAdmin extends Admin
{
    public $permissions = [
        'create' => false,
        'update' => false,
        'remove' => false
    ];

    public $columns = ['subject', 'email', 'phone', 'created_at'];

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Feedback::class;
    }
}
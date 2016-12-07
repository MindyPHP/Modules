<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 19/04/16
 * Time: 17:39
 */

namespace Modules\Feedback\Forms;

use Mindy\Form\ModelForm;
use Modules\Feedback\Models\BackCall;

class BackCallForm extends ModelForm
{
    public function getModel()
    {
        return new BackCall;
    }
}
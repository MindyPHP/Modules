<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Mindy\Form\ModelForm;
use Modules\Partners\Admin\PartnerAdmin;

class PartnerAdvantageForm extends ModelForm
{
    public $exclude = ['position'];

    public function getModel()
    {
        return new PartnerAdmin();
    }
} 
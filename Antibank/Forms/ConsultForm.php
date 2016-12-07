<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Modules\Antibank\Models\Consult;

class ConsultForm extends RequestForm
{
    public $mailTemplate = 'antibank.consult';

    public function getModel()
    {
        return new Consult();
    }
} 
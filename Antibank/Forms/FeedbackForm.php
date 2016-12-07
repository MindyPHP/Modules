<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Modules\Antibank\Models\Feedback;

class FeedbackForm extends RequestForm
{
    public $mailTemplate = 'antibank.feedback';

    public function getModel()
    {
        return new Feedback();
    }
}
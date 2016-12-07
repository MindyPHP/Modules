<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Modules\Antibank\Models\Contact;

class ContactForm extends RequestForm
{
    public $mailTemplate = 'antibank.contact';

    public function getModel()
    {
        return new Contact();
    }
} 
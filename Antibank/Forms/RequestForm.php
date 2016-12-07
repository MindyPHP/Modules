<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\TextAreaField;
use Mindy\Form\ModelForm;

class RequestForm extends ModelForm
{
    public $exclude = ['created_at'];

    public $mailTemplate = 'antibank.question';

    public function setRenderFields(array $fields = [])
    {
        parent::setRenderFields($fields);
        foreach($this->_fields as $key => $field) {
            if ( is_a($field, CharField::className()) || is_a($field, TextAreaField::className())) {
                $this->_fields[$key]->html['placeholder'] = $field->label;
            }
        }
        return $this;
    }

    public function save()
    {
        $saved = parent::save();
        $data = $this->cleanedData;
        $file = null;
        if (isset($data['file'])) {
            $instance = $this->getInstance();
            $file = $instance->file->getUrl();
            $file = Mindy::app()->request->http->getHostInfo() . $file;
        }
        $site = Mindy::app()->getModule('Sites')->getSite();
        if ($site) {
            Mindy::app()->mail->fromCode($this->mailTemplate, $site->email, [
                'data' => $data,
                'file' => $file
            ]);
        }
        return $saved;
    }
} 
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
use Modules\Antibank\Models\More;
use Modules\Core\Components\ParamsHelper;

class MoreForm extends ModelForm
{
    public $exclude = ['created_at'];

    public function getModel()
    {
        return new More();
    }

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

        Mindy::app()->mail->fromCode('antibank.partner_more', ParamsHelper::get('core.core.email_owner'), [
            'data' => $data
        ]);

        return $saved;
    }
} 
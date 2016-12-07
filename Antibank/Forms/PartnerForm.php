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
use Mindy\Helper\Alias;
use Modules\Antibank\Models\Partner;
use Modules\Core\Components\ParamsHelper;

class PartnerForm extends ModelForm
{
    public $exclude = ['created_at'];

    public function getModel()
    {
        return new Partner();
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

        Mindy::app()->mail->fromCode('antibank.partner', ParamsHelper::get('core.core.email_owner'), [
            'data' => $data
        ]);

        Mindy::app()->mail->fromCode('antibank.to_partner', $data['email'], [
            'data' => $data
        ], [Alias::get('www') . '/media/Partner.pdf']);

        return $saved;
    }
} 
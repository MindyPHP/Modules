<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 29/03/15 09:48
 */

namespace Modules\CustomFields\Fields;

use Mindy\Form\Fields\Field;
use Mindy\Helper\Json;
use Mindy\Utils\RenderTrait;
use Modules\CustomFields\Models\CustomField;
use Modules\CustomFields\Validators\CustomValidator;

class CustomEditField extends Field
{
    use RenderTrait;

    public function init()
    {
        parent::init();
        $this->validators[] = new CustomValidator();
    }

    public function renderInput()
    {
        $data = $this->getData();
        $fields = $this->getFields();

        return $this->renderTemplate('custom_fields/custom_edit_field.html', [
            'fields' => Json::encode($fields),
            'data' => Json::encode($data),
            'id' => $this->getHtmlId(),
            'name' => $this->getHtmlName(),
        ]);
    }

    public function getFields()
    {
        $fieldsRaw = CustomField::objects()->all();
        $data = [];
        foreach($fieldsRaw as $field) {
            $data[$field->id] = [
                'id' => $field->id,
                'name' => $field->name,
                'list' => $field->list,
                'type' => $field->type
            ];
        }
        return $data;
    }

    public function getData()
    {
        $data = $this->getValue();
        if (is_string($data)) {
            $data = Json::decode($data);
        }
        return $data ?: [];
    }
}
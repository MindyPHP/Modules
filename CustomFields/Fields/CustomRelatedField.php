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
use Mindy\Orm\Model;
use Mindy\Utils\RenderTrait;
use Modules\CustomFields\Models\CustomField;
use Modules\CustomFields\Validators\CustomValidator;

class CustomRelatedField extends Field
{
    use RenderTrait;

    public $fieldsHolder = 'category';
    public $holderRelation = 'custom_fields';
    // @TODO: release
    public $order = 'position';

    public function init()
    {
        parent::init();
        $this->validators[] = new CustomValidator();
    }

    public function renderInput()
    {
        $data = $this->getData();
        $fields = $this->getFields();

        return $this->renderTemplate('custom_fields/custom_edit_related.html', [
            'fields' => Json::encode($fields),
            'data' => Json::encode($data),
            'id' => $this->getHtmlId(),
            'name' => $this->getHtmlName(),
            'watch' => $this->getHtmlPrefix() . $this->fieldsHolder
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
        $requiredData = [];
        $required = $this->getRequiredFields();
        foreach($required as $fieldId) {
            if (isset($data[$fieldId])) {
                $requiredData[$fieldId] = $data[$fieldId];
            } else {
                $requiredData[$fieldId] = [
                    'value' => ''
                ];
            }
        }
        return $requiredData ?: [];
    }

    public function getRequiredFields()
    {
        $fields = [];

        $instance = $this->getForm()->getModel();

        $relationPk = isset($_GET['relation']) ? $_GET['relation'] : null;
        if (is_null($relationPk)) {
            $relationPk = $this->getForm()->{$this->fieldsHolder}->getValue();
        }
        if ($relationPk instanceof Model) {
            $relationPk = $relationPk->pk;
        }

        if ($relationPk) {
            $fieldRelation = $instance->getField($this->fieldsHolder);
            $modelClass = $fieldRelation->modelClass;
            $model = $modelClass::objects()->filter(['pk' => $relationPk])->limit(1)->get();
            if ($model) {
                $fields = $model->{$this->holderRelation}->valuesList(['id'], true);
            }
        }
        return $fields;
    }
}
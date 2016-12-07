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
 * @date 25/03/15 14:04
 */

namespace Modules\SortableMany\Fields;


use Mindy\Base\Mindy;
use Mindy\Form\Fields\Field;
use Mindy\Helper\Json;
use Mindy\Utils\RenderTrait;

class SortableManyToManyField extends Field
{
    use RenderTrait;

    public function renderInput()
    {
        $selected = [];

        $instance = $this->getForm()->getInstance();
        $field = $instance->getField($this->getName());

        $modelClass = $field->modelClass;
        $models = $modelClass::objects()->all();

        $manager = $field->getManager();

        $qs = $manager->getQuerySet();

        $selectedTmp = $qs->order([$manager->relatedTableAlias . '.' . 'position'])->all();
        foreach ($selectedTmp as $model) {
            $selected[$model->pk] = (string) $model;
        }

        $available = [];
        foreach ($models as $model) {
            if (!array_key_exists($model->pk, $selected)) {
                $available[$model->pk] = (string) $model;
            }
        }

        return $this->renderTemplate('sortable_many/field.html', [
            'selected' => $selected,
            'available' => $available,
            'id' => $this->getHtmlId(),
            'sortData' => Json::encode([
                'primaryKey' => $instance->pk,
                'primaryModelColumn' => $manager->primaryModelColumn,
                'modelColumn' => $manager->modelColumn,
                'modelClass' => $field->through
            ]),
            'sortUrl' => Mindy::app()->urlManager->reverse('sortable_many:sort'),
            'instance' => $instance
        ]);
    }
} 
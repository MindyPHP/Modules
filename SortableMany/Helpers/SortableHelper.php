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
 * @date 21/08/15 14:21
 */
namespace Modules\SortableMany\Helpers;

class SortableHelper 
{
    public static function sort($model, $fieldName, $fetch = false)
    {
        $field = $model->getField($fieldName);
        $manager = $field->getManager();
        $qs = $manager->getQuerySet();
        $qs = $qs->order([$manager->relatedTableAlias . '.' . 'position']);
        if ($fetch) {
            return $qs->all();
        }
        return $qs;
    }
}
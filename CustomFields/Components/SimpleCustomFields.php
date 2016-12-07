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
 * @date 24/03/15 10:29
 */

namespace Modules\CustomFields\Components;


use Modules\CustomFields\Models\CustomField;
use Modules\CustomFields\Models\CustomManager;

/**
 * trait для работы с пользовательскими полями без использования таблиц значения
 * Class SimpleCustomFields
 * @package Modules\CustomFields\Components
 *
 * @property int id
 * @property array|null custom_data
 */
trait SimpleCustomFields
{
    /**
     * Установка значения кастомного поля
     *
     * @param \Modules\CustomFields\Models\CustomField $field
     * @param mixed $value
     */
    public function setCustomValue($field, $value)
    {
        $this->setCustomJson($field, $value);
    }

    /**
     * Запись значения в массив внутри самой модели. Необходимо для вывода данных.
     * Значения будут выводится вообще без дополнительных затрат.
     * Формат - произвольный. Можно хранить что угодно - как удобно именно вам для вывода.
     * Представленный ниже формат подойдет для большинства задач.
     *
     * @param \Modules\CustomFields\Models\CustomField  $field
     * @param mixed $value
     */
    public function setCustomJson($field, $value)
    {
        $data = $this->getJsonCustomData();

        $data[$field->id] = [
            'field_name' => $field->name,
            'value' => $value,
            'human_value' => $field->humanizeValue($value)
        ];

        $this->setJsonCustomData($data);
    }

    /**
     * Получение значения кастомного поля
     *
     * @param $field
     * @return null
     */
    public function getCustomValue($field)
    {
        $id = $field;
        if (is_object($field)) {
            $id = $field->id;
        }
        $data = $this->getJsonCustomData();
        if (isset($data[$id]) && isset($data[$id]['human_value'])) {
            return $data[$id]['human_value'];
        }
        return null;
    }

    public function getJsonCustomData()
    {
        $data = $this->custom_data;
        return is_array($data) ? $data : [];
    }

    public function setJsonCustomData($data)
    {
        $this->custom_data = $data;
    }

    /**
     * Очистка значений всех кастомных полей (при удалении модели)
     */
    public function clearCustom()
    {
        $this->setJsonCustomData([]);
    }

    /**
     * Очистка значения кастомного поля (при удалении поля)
     */
    public function clearField($field)
    {
        $data = $this->getJsonCustomData();
        if (isset($data[$field->id])) {
            unset($data[$field->id]);
        }
        $this->setJsonCustomData($data);
    }

    /**
     * Проверка на заполнение custom_data методом $model->custom_data = {1: {value: 2}, 2: {value: 4}, 'rewrite': True}
     * Выполнять в beforeSave()
     */
    public function checkCustomData()
    {
        $data = $this->getJsonCustomData();
        if (isset($data['rewrite'])) {
            unset($data['rewrite']);
            $this->clearCustom();
            foreach ($data as $pk => $info) {
                $field = CustomField::objects()->get(['pk' => $pk]);
                if (isset($info['value']) && $field) {
                    $this->setCustomValue($field, $info['value']);
                }
            }
        }
    }
} 
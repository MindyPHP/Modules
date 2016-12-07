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
 * @date 29/03/15 11:01
 */

namespace Modules\CustomFields\Validators;

use Mindy\Helper\Json;
use Mindy\Validation\Validator;
use Modules\CustomFields\Models\CustomField;

class CustomValidator extends Validator
{
    public function validate($value)
    {
        $data = $this->getData($value);
        foreach($data as $pk => $info) {
            $field = $this->fetchField($pk);
            if ($field) {
                $val = $info['value'];
                $validated = $field->validateValue($val);
                if ($validated !== true) {
                    $this->addError(strtr('{field}: {error}', [
                        '{field}' => $field->name,
                        '{error}' => $validated
                    ]));
                }
            }
        }
        return $this->hasErrors() === false;
    }

    public function fetchField($pk)
    {
        return CustomField::objects()->get(['pk' => $pk]);
    }

    public function getData($data)
    {
        if (is_string($data)) {
            $data = Json::decode($data);
        }
        return $data;
    }
}
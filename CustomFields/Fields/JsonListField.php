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
 * @date 26/03/15 11:22
 */

namespace Modules\CustomFields\Fields;

use Mindy\Form\Fields\Field;
use Mindy\Helper\Json;
use Mindy\Utils\RenderTrait;

class JsonListField extends Field
{
    use RenderTrait;

    public function renderInput()
    {
        $data = $this->getValue();
        if ($data && !is_array($data)) {
            $data = Json::decode($data);
        }
        $data = $data ?: [];
        return $this->renderTemplate('custom_fields/json_list_field.html', [
            'id' => $this->getHtmlId(),
            'name' => $this->getHtmlName(),
            'data' => $data,
            'encoded' => Json::encode($data)
        ]);
    }
} 
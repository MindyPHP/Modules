<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/01/15 14:51
 */

namespace Modules\Forum\Fields;

use Mindy\Form\Fields\Field;
use Mindy\Utils\RenderTrait;

class AttachmentsField extends Field
{
    use RenderTrait;

    public function render()
    {
        return $this->renderTemplate("forum/_attachments.html");
    }
}

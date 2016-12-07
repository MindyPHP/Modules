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
 * @date 19/02/15 08:36
 */
namespace Modules\Vacants\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\ModelForm;
use Modules\Vacants\Models\Response;

class ResponseForm extends ModelForm
{
    public function getModel()
    {
        return new Response;
    }

    public function save()
    {
        $saved = parent::save();

        if ($saved) {
            Mindy::app()->mail->fromCode('vacants.new_response', Mindy::app()->managers, [
                'model' => $this->getInstance()
            ]);
        }

        return $saved;
    }
}
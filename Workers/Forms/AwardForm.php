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
 * @date 13/11/14 10:41
 */
namespace Modules\Workers\Forms;

use Mindy\Form\ModelForm;
use Modules\Workers\Models\Award;
use Modules\Workers\Models\Worker;
use Modules\Workers\WorkersModule;

class AwardForm extends ModelForm
{
    public $exclude = ['worker'];

    public function getModel()
    {
        return new Award;
    }

    public function getName()
    {
        return WorkersModule::t('Awards');
    }
}
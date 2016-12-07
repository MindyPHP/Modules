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
 * @date 27/01/16 14:57
 */
namespace Modules\Multiple\Forms;

use Mindy\Form\Fields\HiddenField;
use Mindy\Form\ModelForm;

class MultipleForm extends ModelForm
{
    public $ownerField;
    public $ownerPk;

    public function getFields()
    {
        return [
            $this->ownerField => HiddenField::className()
        ];
    }

    public function init()
    {
        parent::init();
        $this->setOwnerAttribute();
    }

    public function getOwnerPk()
    {
        return $this->_ownerPk;
    }

    public function setOwnerAttribute()
    {
        if (!$this->ownerPk && $this->getInstance()->{$this->ownerField}) {
            $this->ownerPk = $this->getInstance()->{$this->ownerField}->pk;
        }
        if ($this->ownerPk) {
            $this->setAttributes([
                $this->ownerField => $this->ownerPk
            ]);
        }
    }
}
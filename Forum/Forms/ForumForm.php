<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 26/10/14.10.2014 21:24
 */

namespace Modules\Forum\Forms;

use Mindy\Form\Fields\DropDownField;
use Mindy\Form\ModelForm;
use Modules\Forum\ForumModule;

class ForumForm extends ModelForm
{
    public function getFields()
    {
        $model = $this->getInstance();
        return [
            'parent' => [
                'class' => DropDownField::className(),
                'choices' => function () use ($model) {
                        $list = ['' => ''];

                        $qs = $model->tree()->order(['root', 'lft']);
                        if ($model->getIsNewRecord()) {
                            $parents = $qs->all();
                        } else {
                            $parents = $qs->exclude(['pk' => $model->pk])->all();
                        }
                        foreach ($parents as $model) {
                            $level = $model->level ? $model->level - 1 : $model->level;
                            $list[$model->pk] = $level ? str_repeat("..", $level) . ' ' . $model->name : $model->name;
                        }

                        return $list;
                    },
                'label' => ForumModule::t('Parent')
            ],
        ];
    }
}

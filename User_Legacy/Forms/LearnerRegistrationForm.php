<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 09/03/16
 * Time: 17:19
 */

namespace Modules\User\Forms;

use Mindy\Form\Fields\DateField;
use Mindy\Form\Fields\DropDownField;
use Modules\Classroom\ClassroomModule;
use Modules\Classroom\Models\Classroom;
use Modules\User\UserModule;

class LearnerRegistrationForm extends BaseRegistrationForm
{
    public function getFields()
    {
        $years = [
            null => ''
        ];
        foreach (range(1990, (int)date('Y')) as $year) {
            $years[] = $year;
        }

        $classes = [];
        foreach (Classroom::objects()->valuesList(['id', 'name']) as $cls) {
            $classes[$cls['id']] = $cls['name'];
        }

        return array_merge(parent::getFields(), [
            'classroom' => [
                'class' => DropDownField::class,
                'label' => ClassroomModule::t('Classroom'),
                'choices' => $classes
            ],
            'education_start_at' => [
                'class' => DropDownField::class,
                'choices' => $years,
                'label' => UserModule::t('Education start date')
            ],
            'education_end_at' => [
                'class' => DropDownField::class,
                'choices' => $years,
                'label' => UserModule::t('Education end date')
            ]
        ]);
    }
}
<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 09/03/16
 * Time: 17:19
 */

namespace Modules\User\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\DropDownField;
use Modules\User\UserModule;

class TeacherRegistrationForm extends BaseRegistrationForm
{
    public function getFields()
    {
        $years = [
            null => ''
        ];
        foreach (range(1990, (int)date('Y')) as $year) {
            $years[] = $year;
        }
        return array_merge(parent::getFields(), [
            'post' => [
                'class' => CharField::class,
                'label' => UserModule::t('Post')
            ],
            'direction' => [
                'class' => CharField::class,
                'label' => UserModule::t('Direction')
            ],
            'job_start_at' => [
                'class' => DropDownField::class,
                'choices' => $years,
                'label' => UserModule::t('Job start at')
            ],
            'job_end_at' => [
                'class' => DropDownField::class,
                'choices' => $years,
                'label' => UserModule::t('Job end at')
            ]
        ]);
    }
}
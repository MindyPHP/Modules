<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 10/03/16
 * Time: 11:17
 */

namespace Modules\User\Forms;

use Modules\Main\MainModule;

class LearnerProfileForm extends BaseProfileForm
{
    public function getFieldsets()
    {
        $fieldsets = parent::getFieldsets();
        unset($fieldsets[MainModule::t('Work')]);
        return $fieldsets;
    }
}
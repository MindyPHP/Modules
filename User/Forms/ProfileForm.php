<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 21:35
 */

namespace Modules\User\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\ModelForm;

class ProfileForm extends ModelForm
{
    public function getModel()
    {
        /** @var \Modules\User\UserModule $module */
        $module = Mindy::app()->getModule('User');
        return $module->getProfileModel();
    }
}
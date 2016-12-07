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
 * @date 06/11/14 10:29
 */
namespace Modules\Nav\Forms;

use Modules\Menu\Forms\MenuForm;
use Modules\Nav\Models\Nav;

class NavForm extends MenuForm
{
    public function getModel()
    {
        return new Nav;
    }
}
<?php

namespace Modules\Core\Controllers;

use Modules\Core\Components\MetaTrait;

/**
 * FrontendController class file.
 *
 * @author Falaleev Maxim <max@studio107.com>
 * @link http://studio107.ru/
 * @copyright Copyright &copy; 2010-2012 Studio107
 * @license http://www.cms107.com/license/
 * @package modules.core.components
 * @since 1.1.1
 * @version 1.0
 *
 */
class FrontendController extends Controller
{
    use MetaTrait;

    public function init()
    {
        parent::init();
        header('Cache-Control: max-age=0');
    }

    /**
     * Returns the access rules for this controller.
     * Override this method if you use the {@link filterAccessControl accessControl} filter.
     * @return array list of access rules. See {@link CAccessControlFilter} for details about rule specification.
     */
    public function accessRules()
    {
        return [
            [
                // deny all users
                'allow' => true,
                'users' => ['*'],
            ],
        ];
    }
}

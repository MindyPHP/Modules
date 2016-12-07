<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Mindy\Controller\BaseController;
use Mindy\Helper\Json;
use Mindy\Helper\Traits\RenderTrait;
use Modules\User\Permissions\PermissionControlFilter;
use Modules\User\Permissions\Rule;

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 02/04/14.04.2014 16:47
 */
class Controller extends BaseController
{
    use RenderTrait;

    public function init()
    {
        parent::init();

        if (MINDY_DEBUG) {
            header('Cache-Control: max-age=0');
        }
    }

    public function render($view, array $data = [])
    {
        $site = null;
        if (Mindy::app()->hasModule('Sites')) {
            $site = Mindy::app()->getModule('Sites')->getSite();
        }
        return $this->renderTemplate($view, array_merge([
            'debug' => MINDY_DEBUG,
            'this' => $this,
            'site' => $site,
            'app' => Mindy::app(),
            'locale' => Mindy::app()->locale
        ], $data));
    }

    public function json(array $data = [])
    {
        if (defined('MINDY_TESTS') == false) {
            header('Content-Type: application/json');
        }
        return JSON::encode($data);
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
                // allow only authorized users
                'allow' => true,
                'users' => ['@']
            ],
            [
                // deny all users
                'allow' => false,
                'users' => ['*'],
            ],
        ];
    }

    public function filters()
    {
        return [
            [
                'class' => PermissionControlFilter::class,
                'allowedActions' => $this->allowedActions(),
                'rules' => $this->accessRules(),
                'deniedCallback' => [$this, 'accessDenied']
            ]
        ];
    }

    /**
     * @return array разрешенные действия (actions) по умолчанию
     */
    public function allowedActions()
    {
        return [];
    }

    /**
     * Denies the access of the user.
     * @param string $message the message to display to the user.
     * This method may be invoked when access check fails.
     * @throws \Mindy\Exception\HttpException when called unless login is required.
     */
    public function accessDenied($rule = null)
    {
        $this->error(403);
    }
}

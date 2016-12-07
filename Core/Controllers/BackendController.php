<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Mindy\Exception\HttpException;
use Mindy\Locale\Translate;
use Modules\Core\Components\MetaTrait;

class BackendController extends Controller
{
    use MetaTrait;

    public function init()
    {
        parent::init();
        header('Cache-Control: max-age=0');
    }

    public function accessRules()
    {
        return [
            [
                // allow only authorized users
                'allow' => true,
                'users' => ['@'],
                'deniedCallback' => [self::class, 'actionAccessDenied'],
                'expression' => function ($user) {
                    return $user->is_staff || $user->is_superuser;
                }
            ],
            [
                // deny all users
                'allow' => false,
                'users' => ['*'],
                'deniedCallback' => function() {
                    Mindy::app()->request->redirect('admin:login');
                }
            ],
        ];
    }

    public static function actionAccessDenied($rule = null)
    {
        $t = Translate::getInstance();
        throw new HttpException(403, $t->t('main', 'You are not authorized to perform this action.'));
    }
}

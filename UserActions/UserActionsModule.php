<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 18/02/16
 * Time: 11:22
 */

namespace Modules\UserActions;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\User\Models\Session;
use Modules\UserActions\Models\UserLog;

class UserActionsModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('user_actions', function ($by = 10) {
            return UserLog::objects()->limit($by)->order(['-created_at'])->all();
        });

        $signal = Mindy::app()->signal;
        $signal->handler('\Mindy\Orm\Model', 'afterSave', [self::className(), 'afterSaveModel']);
        $signal->handler('\Mindy\Orm\Model', 'afterDelete', [self::className(), 'afterDeleteModel']);
    }

    public static function afterSaveModel($owner, $isNew)
    {
        self::recordActionInternal($owner, $isNew ? 'was created' : 'was updated');
    }

    public static function afterDeleteModel($owner)
    {
        self::recordActionInternal($owner, 'was deleted');
    }

    public static function recordActionInternal($owner, $text)
    {
        if (defined('MINDY_TESTS')) {
            return;
        }

        $user = Mindy::app()->getUser();
        if (
            in_array($owner->className(), [UserLog::class, Session::class]) ||
            $user->is_staff ||
            $user->is_superuser
        ) {
            return;
        } else {
            $url = method_exists($owner, 'getAbsoluteUrl') ? $owner->getAbsoluteUrl() : null;
            $message = strtr('{model} {url} ' . $text, [
                '{model}' => $owner->classNameShort()
            ]);
            $app = Mindy::app();
            $module = $owner->getModule();
            UserLog::objects()->create([
                'user' => $app->getUser()->getIsGuest() ? null : $app->getUser(),
                'module' => $owner->getModuleName(),
                'model' => $owner->classNameShort(),
                'url' => $url,
                'ip' => $app->getUser()->getIp(),
                'name' => (string)$owner,
                'message' => $module->t($message, [
                    '{url}' => $url ? "<a href='" . $owner->getAbsoluteUrl() . "'>" . (string)$owner . "</a>" : (string)$owner,
                ])
            ]);
        }
    }

    public function getName()
    {
        return self::t('User actions');
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                 [
                     'name' => self::t('User actions'),
                     'adminClass' => 'UserLogAdmin'
                 ],
            ]
        ];
    }
}
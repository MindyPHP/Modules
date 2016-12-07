<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 29/03/16
 * Time: 16:33
 */

namespace Modules\User\Library;

use Mindy\Template\Library;

class UserLibrary extends Library
{
    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'check_is_active' => ['\Modules\User\Helpers\UserHelper', 'checkIsActive'],
            'gravatar' => function ($user, $size = 80) {
                $email = $user->email;
                $default = "http://placehold.it/" . $size . "x" . $size;
                return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
            },
            'login_form' => ['\Modules\User\Helpers\UserHelper', 'render']
        ];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return [];
    }
}
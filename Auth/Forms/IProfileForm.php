<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 06/06/16 16:37
 */

namespace Modules\Auth\Forms;

use Modules\User\Models\User;

interface IProfileForm
{
    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user);
}
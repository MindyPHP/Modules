<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\User\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Manager;

/**
 * Class UserManager
 * @package Modules\User\Models
 */
class UserManager extends Manager
{
    public function currentSite()
    {
        if (Mindy::app()->hasModule('Sites')) {
            /** @var \Modules\Sites\SitesModule $site */
            $site = Mindy::app()->getModule('Sites');
            $this->filter(['site' => $site->getSite()]);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->filter(['is_active' => true]);
        return $this;
    }

    /**
     * @return $this
     */
    public function staff()
    {
        $this->filter(['is_staff' => true]);
        return $this;
    }

    /**
     * @return $this
     */
    public function superuser()
    {
        $this->filter(['is_superuser' => true]);
        return $this;
    }
}

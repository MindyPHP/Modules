<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 02/05/16
 * Time: 18:59
 */

namespace Modules\User\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Manager;

class SessionManager extends Manager
{
    public function expired()
    {
        $session = Mindy::app()->session;
        $this->filter(['expire__gte' => time() + $session->getTimeout()]);
        return $this;
    }

    public function notExpired()
    {
        $session = Mindy::app()->session;
        $this->filter(['expire__lte' => time() + $session->getTimeout()]);
        return $this;
    }

    public function latest()
    {
        $this->order(['-created_at']);
        return $this;
    }
}
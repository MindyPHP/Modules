<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11/06/16
 * Time: 01:02
 */

namespace Modules\Social\Components\Provider\OAuth2;

use League\OAuth2\Client\Provider\Google as GoogleBase;
use Modules\Social\Components\Provider\Provider;

class Google extends Provider
{
    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return GoogleBase::class;
    }
}
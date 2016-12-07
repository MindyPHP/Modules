<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11/06/16
 * Time: 01:30
 */

namespace Modules\Social\Components\Provider\OAuth2;

use Max107\OAuth2\Client\Provider\Odnoklassniki as OdnoklassnikiBase;
use Modules\Social\Components\Provider\Provider;

class Odnoklassniki extends Provider
{
    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return OdnoklassnikiBase::class;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/06/16
 * Time: 22:59
 */

namespace Modules\Social\Components\Provider\OAuth1;

use League\OAuth1\Client\Server\Twitter as TwitterProvider;
use Modules\Social\Components\Provider\Provider;

class Twitter extends Provider
{
    public $attributeMap = [
        'id' => 'uid',
        'name' => 'nickname',
        'email' => 'email',
        'avatar' => 'imageUrl',
    ];

    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return TwitterProvider::class;
    }
}
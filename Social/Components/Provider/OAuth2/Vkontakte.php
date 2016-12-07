<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11/06/16
 * Time: 01:10
 */

namespace Modules\Social\Components\Provider\OAuth2;

use Autowp\OAuth2\Client\Provider\Vk;
use Modules\Social\Components\Provider\Provider;

class Vkontakte extends Provider
{
    public $attributeMap = [
        'id' => 'uid',
        'email' => 'email',
        'avatar' => 'photo_big',
        'birthday' => 'bdate',
        'gender' => 'sex'
    ];

    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return Vk::class;
    }
}
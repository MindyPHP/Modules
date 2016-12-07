<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/06/16
 * Time: 21:57
 */

namespace Modules\Social\Components\Provider\OAuth2;

use League\OAuth2\Client\Provider\Facebook as BaseFacebook;
use Modules\Social\Components\Provider\Provider;

class Facebook extends Provider
{
    public $attributeMap = [
        'id' => 'id',
        'email' => 'email',
        'name' => 'name',
        'link' => 'link',
        'gender' => 'gender',
        'birthday' => 'birthday'
    ];

    public $scope = ['email'];

    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return BaseFacebook::class;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11/06/16
 * Time: 01:44
 */

namespace Modules\Social\Components\Provider\OAuth2;

use Max107\OAuth2\Client\Provider\Mailru as MailruBase;
use Modules\Social\Components\Provider\Provider;

class Mailru extends Provider
{
    /*
    $res = $response[0];
    $user->uid = $res->uid;
    $user->email = $res->email;
    $user->firstName = $res->first_name;
    $user->lastName = $res->last_name;
    $user->name = $user->firstName.' '.$user->lastName;
    $user->gender = $res->sex?'female':'male';
    $user->urls = $res->link;
    if (isset($res->location)) {
        $user->location = $res->location->city->name;
    }
    if ($res->has_pic) {
        $user->imageUrl = $res->pic;
    }
     */

    public $attributeMap = [
        'id' => 'uid',
        'email' => 'email',
        'gender' => 'sex',
        'avatar' => 'pic'
    ];
    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return MailruBase::class;
    }
}
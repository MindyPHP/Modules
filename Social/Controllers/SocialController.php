<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 07/11/14.11.2014 22:27
 */

namespace Modules\Social\Controllers;

use Exception;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Mindy\Base\Mindy;
use Mindy\Helper\Json;
use Modules\Core\Controllers\FrontendController;
use Modules\Social\Components\Provider\IBaseUser;
use Modules\Social\Models\SocialProfile;
use Modules\User\Helpers\UserHelper;
use Modules\User\Models\User;

class SocialController extends FrontendController
{
    public function actionAuth($name)
    {
        if (Mindy::app()->hasComponent('social') === false) {
            throw new Exception('Missing social component');
        }

        /** @var \Modules\Social\Components\Social $social */
        $social = Mindy::app()->social;
        $provider = $social->getProvider($name);

        try {
            // Auth user and return BaseUser instance
            $resourceOwner = $provider->process($this->getRequest());
        } catch (IdentityProviderException $e) {
            die($e->getMessage());
        }

        $user = $this->getOrCreateUser($name, $resourceOwner);
        Mindy::app()->auth->login($user);

        echo $this->render("social/_close.html", [
            'user' => Json::encode($user->toArray()),
            'name' => $name
        ]);
    }

    /**
     * @param \Modules\Social\Components\Provider\IBaseUser $resource
     * @return User
     */
    protected function getOrCreateUser($name, IBaseUser $resource)
    {
        $profile = SocialProfile::objects()->get([
            'social_id' => $resource->getId(),
        ]);

        if ($profile === null) {
            $email = $resource->getEmail();

            $user = Mindy::app()->getUser();
            if ($user->getIsGuest()) {
                $user = User::objects()->get(empty($email) ? ['username' => $resource->getId()] : ['email' => $email]);
                if ($user === null) {
                    $user = UserHelper::createUser([
                        'name' => $resource->getName(),
                        'username' => $resource->getId(),
                        'email' => $email,
                        'is_active' => true
                    ], !empty($email));
                }
            }

            SocialProfile::objects()->create([
                'social_id' => $resource->getId(),
                'info' => $resource->toArray(),
                'user' => $user,
                'provider' => $name
            ]);
        } else {
            $user = $profile->user;
        }

        return $user;
    }
}

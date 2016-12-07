<?php

/**
 * User: max
 * Date: 05/08/15
 * Time: 20:50
 */

namespace Modules\Auth\Middleware;

use Mindy\Base\Mindy;
use Mindy\Helper\Console;
use Mindy\Http\Request;
use Mindy\Http\Traits\HttpErrors;
use Mindy\Middleware\Middleware\Middleware;
use Modules\Auth\Models\Token;

class AuthKeyCheckMiddleware extends Middleware
{
    use HttpErrors;
    /**
     * @var bool
     */
    public $useSubDomains = false;
    /**
     * @var string
     */
    public $authKey = 'X-Auth-Token';
    /**
     * @var string
     */
    public $httpAuthKey = 'token';

    protected function getToken(Request $request)
    {
        $authKey = $request->http->getHeaderValue($this->authKey);
        if (empty($authKey)) {
            // isomorphic-fetch support
            $authKey = $request->http->getHeaderValue(strtolower($this->authKey));
            if (empty($authKey)) {
                $authKey = $request->get->get($this->httpAuthKey);
            }
        }
        return $authKey;
    }

    /**
     * @param Request $request
     * @throws \Mindy\Exception\HttpException
     */
    public function processRequest(Request $request)
    {
        if (Console::isCli() === false) {
            $key = $this->getToken($request);
            if (!empty($key)) {
                $token = Token::objects()->get(['key' => $key]);
                if ($token !== null) {
                    $user = $token->user;
                    $app = Mindy::app();
                    /** @var \Modules\Sites\SitesModule $siteModule */
                    $siteModule = $app->getModule('Sites');
                    if ($this->useSubDomains) {
                        $site = $siteModule->getSite();
                        if (
                            $user &&
                            $user->is_active &&
                            ($site->id == $user->site_id || $user->is_superuser)
                        ) {
                            $app->auth->login($user);
                        }
                    } else if ($user && $user->is_active) {
                        $app->auth->login($user);
                        $siteModule->setSite($user->site);
                    }
                }
            }
        }
    }
}

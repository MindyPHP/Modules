<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/06/16
 * Time: 23:28
 */

namespace Modules\Social\Components\Provider;

use Exception;
use League\OAuth1\Client\Server\Server;
use League\OAuth2\Client\Provider\AbstractProvider;
use Mindy\Base\Mindy;
use Mindy\Helper\Creator;
use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Http\Request;

/**
 * Class Provider
 * @package Modules\Social\Components\Provider
 */
abstract class Provider
{
    use Configurator, Accessors;

    public $scope = [];
    /**
     * @var array provider config
     */
    public $config = [];
    /**
     * @var array
     */
    public $attributeMap = [];
    /**
     * @var \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    private $_instance;
    /**
     * @var string
     */
    private $_name;

    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    abstract public function getProviderClass();

    /**
     * @param $name string
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @param $instance
     */
    public function setProvider($instance)
    {
        $this->_instance = $instance;
    }

    protected function createUrl()
    {
        $app = Mindy::app();
        $host = $app->request->http->getHostInfo();
        return $host . $app->urlManager->reverse('social:auth', ['provider' => $this->_name]);
    }

    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProvider()
    {
        if ($this->_instance === null) {
            $class = $this->getProviderClass();
            $config = array_merge($this->config, [
                'redirectUri' => $this->createUrl()
            ]);

            if (is_subclass_of($class, Server::class)) {
                $replace = [
                    'clientId' => 'identifier',
                    'clientSecret' => 'secret',
                    'redirectUri' => 'callback_uri'
                ];

                foreach ($replace as $key => $need) {
                    $value = $config[$key];
                    unset($config[$key]);
                    $config[$need] = $value;
                }
            }
            $this->_instance = Creator::createObject($class, $config);
        }
        return $this->_instance;
    }

    /**
     * @param Request $request
     * @return IBaseUser|void
     * @throws Exception
     */
    public function process(Request $request)
    {
        $instance = $this->getProvider();
        if ($instance instanceof AbstractProvider) {
            return $this->processOAuth2($request, $instance);
        } else if ($instance instanceof Server) {
            return $this->processOAuth1($request, $instance);
        }

        throw new Exception('Unknown provider');
    }

    /**
     * @param Request $request
     * @param Server $server
     * @return IBaseUser
     * @throws Exception
     */
    protected function processOAuth1(Request $request, Server $server)
    {
        static $sessionKey = 'temporary_credentials';

        if ($request->get->has('denied')) {
            throw new Exception('Access denied');
        } else if (
            $request->get->has('oauth_token') &&
            $request->get->has('oauth_verifier') &&
            $request->session->has($sessionKey)
        ) {
            // Retrieve the temporary credentials we saved before
            $temporaryCredentials = unserialize($request->session->get($sessionKey));
            $request->session->remove($sessionKey);

            // We will now retrieve token credentials from the server
            $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $request->get->get('oauth_token'), $request->get->get('oauth_verifier'));

            return $this->getUserResource($server->getUserDetails($tokenCredentials));
        } else {
            // Retrieve temporary credentials
            $temporaryCredentials = $server->getTemporaryCredentials();

            // Store credentials in the session, we'll need them later
            $request->session->add($sessionKey, serialize($temporaryCredentials));

            // Second part of OAuth 1.0 authentication is to redirect the
            // resource owner to the login screen on the server.
            $request->redirect($server->getAuthorizationUrl($temporaryCredentials));
        }
    }

    /**
     * @param $data
     * @return BaseUser
     */
    protected function getUserResource($data)
    {
        return new BaseUser($data, $this->attributeMap);
    }

    protected function processOAuth2(Request $request, AbstractProvider $provider)
    {
        static $sessionKey = 'oauth2state';

        if ($request->get->has('code') == false) {
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl(['scope' => $this->scope]);
            $request->session->add($sessionKey, $provider->getState());
            $request->redirect($authUrl);
            Mindy::app()->end();
        } else if ($request->get->has('state') === false || (
                $request->get->has('state') &&
                $request->get->get('state') !== $request->session->get($sessionKey)
            )
        ) {
            // Check given state against previously stored one to mitigate CSRF attack
            $request->session->remove('oauth2state');
            echo 'Invalid state.';
            Mindy::app()->end();
        } else {
            // Try to get an access token (using the authorization code grant)
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->get->get('code')
            ]);

            $resourceOwner = $provider->getResourceOwner($accessToken);
            return $this->getUserResource($resourceOwner->toArray());
        }
    }
}
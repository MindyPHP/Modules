<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/06/16
 * Time: 21:36
 */

namespace Modules\Social\Components;

use Mindy\Base\Mindy;
use Mindy\Helper\Creator;
use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;

class Social
{
    use Configurator, Accessors;

    /**
     * @var \League\OAuth2\Client\Provider\AbstractProvider[]|\League\OAuth1\Client\Server\Server[] $_providers
     */
    private $_providers = [];

    protected function getUrl($name)
    {
        $app = Mindy::app();
        $host = $app->request->http->getHostInfo();
        $url = $app->urlManager->reverse('social:auth', ['provider' => $name]);
        return $host . $url;
    }

    /**
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        foreach ($providers as $name => $config) {
            $this->_providers[$name] = Creator::createObject(array_merge($config, ['name' => $name]));
        }
    }

    /**
     * @return \Modules\Social\Components\Provider\Provider
     */
    public function getProviders()
    {
        return $this->_providers;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasProvider($name)
    {
        return isset($this->_providers[$name]);
    }

    /**
     * @param $name
     * @return \Modules\Social\Components\Provider\Provider
     */
    public function getProvider($name)
    {
        return $this->_providers[$name];
    }
}
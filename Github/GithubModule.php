<?php

namespace Modules\Github;

use Github\Client;
use Github\HttpClient\CachedHttpClient;
use Mindy\Base\Mindy;
use Mindy\Base\Module;

class GithubModule extends Module
{
    private $_client;

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('mindy_version', function ($username, $name) {
            $release = Mindy::app()->cache->get(implode('_', ['github', $username, $name]));
            if ($release === false) {
                $client = Mindy::app()->getModule('Github')->getGithubClient();
                $releases = $client->api('repo')->releases()->all($username, $name);
                $release = array_shift($releases);
            }

            return $release;
        });
    }

    public function fetchUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, PHP_VERSION);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Repositories'),
                    'adminClass' => 'RepoAdmin',
                ],
            ]
        ];
    }
}

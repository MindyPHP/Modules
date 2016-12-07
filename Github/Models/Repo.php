<?php

namespace Modules\Github\Models;

use Mindy\Helper\Json;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DecimalField;
use Mindy\Orm\Model;
use Modules\Github\GithubModule;

class Repo extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => GithubModule::t('Url'),
                'validators' => [
                    function ($value) {
                        if (mb_strpos($value, '/', null, 'UTF-8') === false) {
                            return "Incorrent repository name";
                        }

                        return true;
                    }
                ],
                'helpText' => 'Owner/Repository'
            ],
            'version' => [
                'class' => CharField::className(),
                'editable' => false,
                'null' => true,
                'verboseName' => GithubModule::t('Version')
            ]
        ];
    }

    public function __toString()
    {
        return (string)strtr('0 1', [$this->name, $this->version]);
    }

    public function sync()
    {
        list($username, $name) = explode('/', $this->name);
        $responseRaw = $this->getModule()->fetchUrl(strtr('https://api.github.com/repos/{owner}/{name}/tags?access_token={access_token}', [
            '{owner}' => $username,
            '{name}' => $name,
            '{access_token}' => 'fd40a7829774414eca22627e137fbc043d53d891',
        ]));
        if ($responseRaw) {
            $releases = Json::decode($responseRaw);
            $latest = 0;
            foreach ($releases as $r) {
                if ($r['name'] > $latest) {
                    $latest = $r['name'];
                }
            }
            $this->version = $latest;
            $this->save(['version']);
        }
    }
}

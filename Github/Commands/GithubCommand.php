<?php

namespace Modules\Github\Commands;

use Mindy\Console\ConsoleCommand;
use Modules\Github\Models\Repo;

class GithubCommand extends ConsoleCommand
{
    public function actionSync()
    {
        $repoList = Repo::objects()->all();
        foreach($repoList as $repo) {
            $repo->sync();
        }
    }
}

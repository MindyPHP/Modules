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
 * @date 25/08/14.08.2014 14:38
 */

namespace Modules\Catalog\Commands;

use Mindy\Base\Mindy;
use Mindy\Console\ConsoleCommand;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Meta\Models\Meta;
use Modules\Redirect\Models\Redirect;
use Mindy\Helper\Meta as MetaHelper;
use Modules\Sites\Models\Site;

class MigratePagesCommand extends ConsoleCommand
{
    public $site;

    public function actionIndex()
    {
        $this->site = Site::objects()->filter(['pk' => 1])->get();

        /** @var \Mindy\Query\Connection $db */
        $db = Mindy::app()->db->getDb('centerwoman');
        Redirect::objects()->filter(['pk__gte' => 0])->delete();
        Meta::objects()->filter(['pk__gte' => 0])->delete();
        $categories = $this->syncCategories($db);
        $this->syncPages($db, $categories);
    }

    private function syncCategories($db)
    {
        Category::objects()->filter(['pk__gte' => 0])->delete();

        $categories = [];
        $cmd = $db->createCommand('SELECT * FROM mindy_pages WHERE lft+1!=rgt ORDER BY lft');
        foreach ($cmd->queryAll() as $item) {
            if(isset($item['parent_id'])) {
                $parent = $db->createCommand('SELECT * FROM mindy_pages WHERE id = ' . $item['parent_id'])->queryOne();
            } else {
                $parent = null;
            }
            $c = new Category([
                'name' => $item['name'],
                'old_id' => $item['id'],
                'content' => $item['content'],
                'parent' => $parent ? Category::objects()->getOrCreate([
                        'old_id' => $parent['id'],
                        'name' => $parent['name'],
                        'content' => $parent['content']
                    ]) : null
            ]);
            $c->save();
            $redirect = new Redirect([
                'type' => 301,
                'from_url' => '/'. $item['url'],
                'to_url' => $c->getAbsoluteUrl()
            ]);
            $redirect->save();
            $meta = new Meta([
                'title' => $item['name'],
                'keywords' => MetaHelper::generateKeywords($item['content']),
                'description' => MetaHelper::generateDescription($item['content']),
                'url' => $c->getAbsoluteUrl(),
                'site' => $this->site
            ]);
            $meta->save();
            $categories[$item['id']] = $c;
        }
        return $categories;
    }

    private function syncPages($db, $categories)
    {
        Post::objects()->filter(['pk__gte' => 0])->delete();

        $cmd = $db->createCommand('SELECT * FROM mindy_pages WHERE lft+1=rgt ORDER BY lft');
        foreach ($cmd->queryAll() as $item) {
            if(isset($item['parent_id'])) {
                $parent = $db->createCommand('SELECT * FROM mindy_pages WHERE id = ' . $item['parent_id'])->queryOne();
            } else {
                $parent = null;
            }
            $urlParts = explode('-', $item['url']);
            array_shift($urlParts);
            $shortContent = explode('__pagebreak__', $item['content']);
            $shortContent = array_shift($shortContent);
            $c = new Post([
                'name' => $item['name'],
                'old_id' => $item['id'],
                'content' => str_replace('__pagebreak__', '', $item['content']),
                'content_short' => strip_tags($shortContent),
                'is_published' => true,
                'url' => implode('-', $urlParts),
                'category' => $parent ? Category::objects()->getOrCreate([
                        'old_id' => $parent['id'],
                        'name' => $parent['name'],
                        'content' => $parent['content']
                    ]) : null
            ]);
            $c->save();
            $redirect = new Redirect([
                'type' => 301,
                'from_url' => '/'. $item['url'],
                'to_url' => $c->getAbsoluteUrl()
            ]);
            $redirect->save();
            $meta = new Meta([
                'title' => $item['name'],
                'keywords' => MetaHelper::generateKeywords($item['content']),
                'description' => MetaHelper::generateDescription($item['content']),
                'url' => $c->getAbsoluteUrl(),
                'site' => $this->site
            ]);
            $meta->save();
            $categories[$item['id']] = $c;
        }
    }
}

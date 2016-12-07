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
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;


class MigrateProductsCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        /** @var \Mindy\Query\Connection $db */
        $db = Mindy::app()->db->getDb('centerwoman');
        $this->syncProducts($db, $this->syncCategories($db));
    }

    private function syncCategories($db)
    {
        $categories = [];
        Category::objects()->filter(['pk__gte' => 0])->delete();

        $cmd = $db->createCommand('SELECT * FROM mindy_catalog_category ORDER BY lft');
        foreach ($cmd->queryAll() as $item) {
            $parent = $db->createCommand('SELECT * FROM mindy_catalog_category WHERE id = ' . $item['parent_id'])->queryOne();
            $c = new Category([
                'name' => $item['name'],
                'old_id' => $item['id'],
                'description' => $item['content'],
                'parent' => $parent ? Category::objects()->getOrCreate([
                        'old_id' => $parent['id'],
                        'name' => $parent['name'],
                        'description' => $parent['content']
                    ]) : null
            ]);
            $c->save();
            $categories[$item['id']] = $c;
        }
        return $categories;
    }

    private function syncProducts($db, $categories)
    {
        Product::objects()->filter(['pk__gte' => 0])->delete();

        $cmd = $db->createCommand('SELECT * FROM mindy_catalog_production');
        foreach ($cmd->queryAll() as $item) {
            $p = new Product([
                'default_category_id' => $categories[$item['category_id']]->pk,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'hits' => $item['hits'],
                'is_published' => (bool)$item['status'],
            ]);
            $p->save();
            if(isset($categories[$item['category_id']])) {
                $categories[$item['category_id']]->production->link($p);
            } else {
                echo "Skip: " . $item['id'] . PHP_EOL;
            }
        }
    }
}

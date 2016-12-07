<?php

namespace Modules\Catalog\Tests;

use Mindy\Base\Mindy;
use Mindy\Base\Tests\BaseTestCase;
use Modules\Catalog\Controllers\CategoryController;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Sitemap\CategorySitemap;
use PHPUnit_Framework_TestCase;

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 19/08/14.08.2014 13:05
 */
class CategoryTest extends BaseTestCase
{
    protected function getModels()
    {
        return [new Category];
    }

    public function testSimple()
    {
        $this->assertEquals(1, 1);
    }

    public function testRoutes()
    {
        $url = Mindy::app()->urlManager;

        // Test actions
        $this->assertEquals('/catalog/c/foo', $url->reverse('catalog.list', ['/foo']));

        // Test models
        $model = new Category(['name' => 'foo']);
        $this->assertTrue($model->save());
        $this->assertEquals('/foo', $model->url);
        $this->assertEquals('/c/foo', $model->getAbsoluteUrl());

        d($model->getAbsoluteUrl(), $url->dispatch('get', $model->getAbsoluteUrl()));
        $this->assertTrue(is_array($url->dispatch('get', '/c' . $model->getAbsoluteUrl())));
    }

    public function testAdmin()
    {
        $r = Mindy::app()->urlManager->reverse('admin.list', ['catalog', 'CatalogAdmin']);
        $this->assertEquals('/core/list/catalog/CatalogAdmin', $r);
    }
}

<?php

namespace Modules\Catalog\Tests;

use Mindy\Base\Mindy;
use Mindy\Base\Tests\BaseTestCase;
use Modules\Catalog\Controllers\ProductController;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Order;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Sitemap\ProductSitemap;
use Modules\Mail\Models\Mail;
use Modules\Mail\Models\MailTemplate;
use Modules\User\Models\User;

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
class ProductTest extends BaseTestCase
{
    protected function getModels()
    {
        return [new Product, new Category, new Order, new User, new MailTemplate, new Mail];
    }

    protected function getController()
    {
        $module = Mindy::app()->getModule('Catalog');
        return new ProductController('product', $module);
    }

    public function testCreate()
    {
        $p = new Product([
            'name' => 'foo',
            'price' => 100
        ]);
        $this->assertTrue($p->save());
        $this->assertEquals(1, $p->pk);
        $this->assertNotNull($p->created_at);
        $this->assertNull($p->updated_at);
        $this->assertNull($p->default_category);
        $this->assertFalse($p->is_published);
        $this->assertEquals('/p/1', $p->getAbsoluteUrl());
        $this->assertEquals([], $p->category->asArray()->all());

        $c = new Category(['name' => 'test']);
        $this->assertTrue($c->save());
        $this->assertEquals([], $c->production->asArray()->all());

        $p->category->link($p);
        $this->assertEquals([
            [
                'id' => 1,
                'name' => 'test',
                'url' => '/test',
                'image' => null,
                'parent_id' => null,
                'lft' => 1,
                'rgt' => 2,
                'level' => 1,
                'root' => 1,
            ]
        ], $p->category->asArray()->all());
        $p->category->unlink($p);
        $this->assertEquals([], $p->category->asArray()->all());

        $c->production->link($p);
        $this->assertEquals([
            [
                'id' => 1,
                'name' => 'foo',
                'price' => 100,
                'description' => null,
                'default_category_id' => null,
                'created_at' => $p->created_at,
                'updated_at' => null,
                'is_published' => 'FALSE',
            ]
        ], $c->production->asArray()->all());
        $c->production->unlink($p);

        $this->assertEquals([], $c->production->asArray()->all());
    }

    public function testOrder()
    {
        // Создание почтового шаблона
        $tpl = new MailTemplate([
            'code' => 'catalog.order',
            'subject' => 'new order',
            'template' => 'Name: {{ model.name }} Price: {{ model.price }}',
            'is_locked' => false
        ]);
        $this->assertTrue($tpl->save());

        // Создание продукта
        $p = new Product(['name' => 'foo', 'price' => 100]);
        $this->assertTrue($p->save());

        // Создание нового заказа по продукту
        $o = $p->order(['admin@admin.com' => 'receiver']);
        $this->assertEquals(1, $o->pk);
        $this->assertEquals('new order', $o->name);
        $this->assertEquals('Name: foo Price: 100', $o->order);

        // Отправка письма происходит выше в методе order(). Тестируем отправленные письма.
        $mail = Mindy::app()->mail;
        $this->assertEquals(1, count($mail->out));
        $message = $mail->out[0];
        $this->assertEquals('new order', $message->getSubject());
        $this->assertEquals(['admin@admin.com' => 'receiver'], $message->getTo());
        $this->assertEquals(['admin@admin.com' => 'sender'], $message->getFrom());
    }

    public function testSitemap()
    {
        $sitemap = new ProductSitemap();
        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"/>
', $sitemap->render(false));

        $model = new Product(['name' => '123', 'price' => 123, 'is_published' => true]);
        $this->assertTrue($model->save());
        $this->assertEquals('/p/1', $model->getAbsoluteUrl());

        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
  <url>
    <loc>/p/1</loc>
    <lastmod>'.date(DATE_W3C, strtotime($model->updated_at ? $model->updated_at : $model->created_at)).'</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>
', $sitemap->render(false));
    }
}

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
 * @date 28/10/14.10.2014 18:17
 */

namespace Modules\Search;

use Elastica\Document;
use Elastica\Exception\NotFoundException;
use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Alias;

class SearchModule extends Module
{
    public static $enableIndexing = true;
    /**
     * @var string index name
     */
    public $searchIndexName = 'search';
    /**
     * @var array index settings
     */
    public $searchIndexSettings = [
        'number_of_shards' => 4,
        'number_of_replicas' => 1,
        "analysis" => [
            "char_filter" => [
                "ru" => [
                    "type" => "mapping",
                    "mappings" => ["Ё=>Е", "ё=>е"]
                ]
            ],
            "analyzer" => [
                "my_analyzer" => [
                    "type" => "custom",
                    "tokenizer" => "my_ngram_tokenizer",
                    "filter" => [
                        "lowercase",
                        "russian_morphology",
                        "english_morphology",
                        "my_stopwords",
                        "ru"
                    ],
                    "char_filter" => [
                        "ru"
                    ]
                ]
            ],
            "tokenizer" => [
                "my_ngram_tokenizer" => [
                    "type" => "edgeNGram",
                    "min_gram" => "3",
                    "max_gram" => "5",
                    "token_chars" => ["letter", "digit"]
                ]
            ],
            "filter" => [
                "ru" => [
                    "type" => "hunspell",
                    "locale" => "ru",
                    "dedup" => true,
                    "ignoreCase" => true
                ],
                "my_stopwords" => [
                    "type" => "stop",
                    "ignore_case" => true,
                    "stopwords" => "а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,из-за,из-под,кроме,между,обо,через,вне,будто,вдобавок,именно,кабы,как-то,както,притом,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with"
                ]
            ]
        ]
    ];

    private static $_types = [];

    public static function preConfigure()
    {
        $app = Mindy::app();
        $types = self::getTypes();
        if (self::$enableIndexing) {
            foreach ($types as $name => $search) {
                $model = $search->getModel();

                $signal = $app->signal;
                $className = $model->className();
                /**
                 * Create|update entry in index after create|update model
                 */
                $signal->handler($className, 'afterSave', function ($owner, $isNew) use ($name, $search) {
                    /** @var \Modules\Search\SearchModule $module */
                    list($pk, $data) = $search->fromModel($owner);
                    $module = Mindy::app()->getModule('Search');
                    $elasticaIndex = $module->getSearchIndex();
                    $elasticaType = $elasticaIndex->getType($name);
                    if (!$isNew) {
                        try {
                            $elasticaType->deleteById($pk);
                        } catch (NotFoundException $e) {

                        }
                    }

                    $elasticaType->addDocument(new Document($pk, $data));
                });
                /**
                 * Delete entry from index after delete model
                 */
                $signal->handler($className, 'afterDelete', function ($owner) use ($name, $search) {
                    /** @var \Modules\Search\SearchModule $module */
                    $module = Mindy::app()->getModule('Search');
                    $elasticaIndex = $module->getSearchIndex();
                    $elasticaType = $elasticaIndex->getType($name);
                    $elasticaType->deleteById($owner->pk);
                });
            }
        }
    }

    /**
     * @return \Modules\Search\Components\SearchIndex[]
     */
    public static function getTypes()
    {
        if (empty(self::$_types)) {
            $path = Alias::get('application.config.search') . '.php';
            if (is_file($path)) {
                self::$_types = include_once($path);
            }
        }
        return self::$_types;
    }

    /**
     * @return \Elastica\Index
     */
    public function getSearchIndex()
    {
        return $this->getClient()->getIndex($this->searchIndexName);
    }

    /**
     * @return \Elastica\Client
     */
    public function getClient()
    {
        return $this->getComponent('search');
    }
}

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
 * @date 11/11/14.11.2014 10:27
 */

namespace Modules\Search\Commands;

use Elastica\Document;
use Elastica\Type;
use Elastica\Type\Mapping;
use Exception;
use Mindy\Console\ConsoleCommand;
use Mindy\Helper\Console;

class SearchCommand extends ConsoleCommand
{
    public function actionCreate()
    {
        /** @var \Modules\Search\SearchModule $module */
        $module = $this->getModule();
        echo Console::color($module->t("Create index")) . PHP_EOL;
        $elasticaIndex = $module->getSearchIndex();
        $elasticaIndex->create($module->searchIndexSettings, true);

        foreach ($module->getTypes() as $name => $search) {
            $elasticaType = $elasticaIndex->getType($name);
            $mapping = new Mapping();
            $mapping->setType($elasticaType);

            foreach ($search->getParams() as $key => $value) {
                $mapping->setParam($key, $value);
            }

            $properties = $search->getProperties();
            if (count($properties) > 0) {
                $mapping->setProperties($properties);
            }
            $mapping->send();
        }
        echo Console::color("Complete", Console::FOREGROUND_LIGHT_GREEN) . PHP_EOL;
    }

    public function actionDelete($force = false)
    {
        /** @var \Modules\Search\SearchModule $module */
        $module = $this->getModule();
        echo Console::color($module->t("Delete index"), Console::FOREGROUND_LIGHT_RED) . PHP_EOL;
        if ($force || Console::prompt($module->t("You really want to delete search index?"), 'Y/n') === 'Y') {
            try {
                $module->getSearchIndex()->delete();
                echo Console::color($module->t("Complete"), Console::FOREGROUND_LIGHT_GREEN) . PHP_EOL;
            } catch (Exception $e) {
                echo Console::color($e->getMessage(), Console::FOREGROUND_LIGHT_RED) . PHP_EOL;
            }
        } else {
            echo Console::color($module->t("Canceled"), Console::FOREGROUND_LIGHT_RED) . PHP_EOL;
        }
    }

    public function actionReindex()
    {
        $this->actionDelete(true);
        $this->actionCreate();

        /** @var \Modules\Search\SearchModule $module */
        $module = $this->getModule();
        echo $module->t("Reindexing, please wait") . PHP_EOL;
        $elasticaIndex = $module->getSearchIndex();
        foreach ($module->getTypes() as $name => $search) {
            $elasticaType = $elasticaIndex->getType($name);
            $model = $search->getModel();
            $models = $search->getQuerySet()->asArray()->all();

            echo $module->t("Indexing {name} - {count}", [
                '{name}' => $name,
                '{count}' => count($models)
            ]) . PHP_EOL;

            $this->bulkInsert($elasticaType, $models, $model->getPkName());
            $elasticaIndex->refresh();
        }
        echo Console::color($module->t("Complete"), Console::FOREGROUND_LIGHT_GREEN) . PHP_EOL;
    }

    private function bulkInsert(Type $elasticaType, $models, $pkName, $count = 500)
    {
        $parts = array_chunk($models, $count);
        foreach ($parts as $models) {
            $documents = [];
            foreach ($models as $data) {
                $documents[] = new Document($data[$pkName], $data);
            }
            $elasticaType->addDocuments($documents);
        }
    }
}

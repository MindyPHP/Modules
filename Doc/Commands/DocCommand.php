<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 20/01/15 14:36
 */

namespace Modules\Doc\Commands;

use Exception;
use FilesystemIterator;
use Mindy\Console\ConsoleCommand;
use Mindy\Helper\Json;
use Mindy\Helper\Meta as MetaHelper;
use Modules\Doc\Models\Page;
use Modules\Meta\Models\Meta;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DocCommand extends ConsoleCommand
{
    protected function readJson($path)
    {
        return file_exists($path) ? Json::decode(file_get_contents($path)) : [];
    }

    /**
     * @param $path
     * @throws Exception
     */
    public function actionIndex($path, $clear = false)
    {
        if (!is_dir($path)) {
            throw new Exception("Directory not found: " . $path);
        }

        if ($clear) {
            Page::objects()->truncate();
        }

        $data = [];
        $di = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $it = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $key => $file) {
            $relativePath = $it->getSubPathName();
            if (strpos($relativePath, '.git', 0) === 0) {
                continue;
            }

            $ignore = [
                '.DS_Store'
            ];
            foreach ($ignore as $i) {
                if (strpos($relativePath, $i, 0) !== false) {
                    continue;
                }
            }

            if (is_dir($key)) {
                $data[$relativePath] = [
                    'url' => strtolower($relativePath),
                    'path' => $key,
                    'json' => $this->readJson($key . '.json'),
                    'is_dir' => true
                ];
            } else if (strpos($key, '.md') !== false) {
                $data[$relativePath] = [
                    'url' => str_replace(['.md', '.json'], '', strtolower($relativePath)),
                    'path' => $key,
                    'json' => $this->readJson(str_replace(['.md', '.json'], '', $key) . '.json'),
                    'markdown' => file_get_contents($key),
                    'is_dir' => false
                ];

            }
        }

        usort($data, function ($a, $b) {
            return mb_strlen($b['url'], 'utf-8') < mb_strlen($a['url'], 'utf-8');
        });

        foreach ($data as $item) {
            if ($item['is_dir'] == false) {
                continue;
            }

            $parent = substr_count($item['url'], '/') >= 1 ? Page::objects()->get(['url' => dirname($item['url'])]) : null;
            $name = isset($item['json']['name']) ? $item['json']['name'] : basename($item['path']);
            $model = Page::objects()->getOrCreate([
                'name' => $name,
                'url' => $item['url'],
                'parent' => $parent,
            ]);
            $this->generateMeta($model, $item);
        }

        foreach ($data as $item) {
            if ($item['is_dir'] == true) {
                continue;
            }

            $parent = substr_count($item['url'], '/') >= 1 ? Page::objects()->get(['url' => dirname($item['url'])]) : null;
            $name = isset($item['json']['name']) ? $item['json']['name'] : basename($item['path']);
            $model = Page::objects()->getOrCreate([
                'name' => $name,
                'url' => $item['url'],
                'content' => $item['markdown'],
                'parent' => $parent
            ]);
            $this->generateMeta($model, $item);
        }
    }

    protected function generateMeta(Page $model, array $item)
    {
        $content = $model->getField('content_html')->getDbPrepValue();
        $title = isset($item['json']['title']) ? $item['json']['title'] : $model->name;
        $keywords = isset($item['json']['keywords']) ? $item['json']['keywords'] : MetaHelper::generateKeywords($content);
        $description = isset($item['json']['description']) ? $item['json']['description'] : MetaHelper::generateDescription($content);
        Meta::objects()->getOrCreate([
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'url' => $model->getAbsoluteUrl()
        ]);
    }
}

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
 * @date 31/10/14.10.2014 13:59
 */

namespace Modules\Doc\Models;

class BaseDoc
{
    public $name;
    public $since;
    public $see;
    public $introduction;
    public $description;

    public $sourcePath;
    public $startLine;
    public $endLine;

    public function loadSource($reflection)
    {
        $filename = $reflection->getFilename();
        if (substr($filename, 0, strlen(MINDY_PATH)) === MINDY_PATH) {
            $this->sourcePath = str_replace('\\', '/', str_replace(MINDY_PATH, '', $reflection->getFileName()));
        } else {
            $this->sourcePath = str_replace('\\', '/', str_replace(BUILD_PATH, '', $reflection->getFileName()));
        }

        $this->startLine = $reflection->getStartLine();
        $this->endLine = $reflection->getEndLine();
    }

    public function getSourceUrl($baseUrl, $line = null)
    {
        if ($line === null) {
            return $baseUrl . $this->sourcePath;
        } else {
            return $baseUrl . $this->sourcePath . '#' . $line;
        }
    }

    public function getSourceCode()
    {
        if (file_exists(BUILD_PATH . $this->sourcePath)) {
            $lines = file(BUILD_PATH . $this->sourcePath);
        } else if (file_exists(MINDY_PATH . $this->sourcePath)) {
            $lines = file(MINDY_PATH . $this->sourcePath);
        } else {
            $lines = file($this->sourcePath);
        }
        return implode("", array_slice($lines, $this->startLine - 1, $this->endLine - $this->startLine + 1));
    }
}

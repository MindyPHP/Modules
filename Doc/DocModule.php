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
 * @date 31/10/14.10.2014 13:56
 */

namespace Modules\Doc;

use Exception;
use Mindy\Base\Module;

class DocModule extends Module
{
    public $docPath;

    public function getDocPath()
    {
        $path = realpath($this->docPath);
        if ($path) {
            return $path;
        }

        throw new Exception("Directory {$this->docPath} not found");
    }
}

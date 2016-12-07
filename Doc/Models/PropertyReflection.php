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
 * @date 31/10/14.10.2014 14:02
 */

namespace Modules\Doc\Models;

class PropertyReflection
{
    protected $name;
    protected $type;
    protected $description;

    public function __construct($line)
    {
        $segs = preg_split('/\s+/', $line, 2);
        $this->type = array_shift($segs);
        $this->name = array_shift($segs);
        $this->description = implode(" ", $segs);
    }

    public function getName()
    {
        return $this->name;
    }
}

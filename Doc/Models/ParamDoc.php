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

class ParamDoc
{
    public $name;
    public $description;
    public $type;
    public $isOptional;
    public $defaultValue;
    public $isPassedByReference;
}

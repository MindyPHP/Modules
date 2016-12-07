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
 * @date 31/10/14.10.2014 14:01
 */

namespace Modules\Doc\Models;

class MethodDoc extends FunctionDoc
{
    public $isAbstract;
    public $isFinal;
    public $isProtected;
    public $isStatic;
    public $isInherited;
    public $definedBy;
}

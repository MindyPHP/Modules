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
 * @date 31/10/14.10.2014 14:00
 */

namespace Modules\Doc\Models;

class ClassDoc extends BaseDoc
{
    public $parentClasses = [];
    public $subclasses = [];
    public $interfaces = [];
    public $isInterface;
    public $isAbstract;
    public $isFinal;

    public $signature;

    public $properties = [];
    public $methods = [];
    public $events = [];
    public $constants = [];

    public $protectedPropertyCount = 0;
    public $publicPropertyCount = 0;
    public $protectedMethodCount = 0;
    public $publicMethodCount = 0;

    public $nativePropertyCount = 0;
    public $nativeMethodCount = 0;
    public $nativeEventCount = 0;

    public $package;
    public $version;
    public $authors = [];
    public $views = [];
}

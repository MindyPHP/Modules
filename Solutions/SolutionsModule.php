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
 * @date 15/09/14.09.2014 15:11
 */

namespace Modules\Solutions;

use Mindy\Base\Module;

class SolutionsModule extends Module
{
    public $commentForm = '\Modules\Solutions\Forms\CommentForm';
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Regions'),
                    'adminClass' => 'RegionAdmin',
                ],
                [
                    'name' => self::t('Banks'),
                    'adminClass' => 'BankAdmin',
                ],
                [
                    'name' => self::t('Solutions'),
                    'adminClass' => 'SolutionAdmin',
                ],
                [
                    'name' => self::t('Comments'),
                    'adminClass' => 'CommentAdmin',
                ]
            ]
        ];
    }
}

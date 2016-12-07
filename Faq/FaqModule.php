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
 * @date 14/09/14.09.2014 13:01
 */

namespace Modules\Faq;

use Mindy\Base\Module;

class FaqModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Categories'),
                    'adminClass' => 'CategoryAdmin',
                ],
                [
                    'name' => self::t('Questions'),
                    'adminClass' => 'QuestionAdmin',
                ]
            ]
        ];
    }
}

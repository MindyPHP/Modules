<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 09/12/14 16:10
 */
namespace Modules\Sms;

use Mindy\Base\Module;

class SmsModule extends Module
{
    public $model = '\Modules\Sms\Models\Sms';
    /**
     * @var null
     */
    public $testPhone = null;
    /**
     * @var null
     */
    public $mainPhone = null;

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->t('Sms templates'),
                    'adminClass' => 'SmsTemplateAdmin'
                ]
            ]
        ];
    }
}

<?php

namespace Modules\Feedback;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Feedback\Forms\FeedbackForm;

class FeedbackModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'FeedbackAdmin',
                ],
                [
                    'name' => self::t('Back calls'),
                    'adminClass' => 'BackCallAdmin',
                ]
            ]
        ];
    }
}

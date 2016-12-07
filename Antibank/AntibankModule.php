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
 * @date 11/09/14.09.2014 14:25
 */

namespace Modules\Antibank;

use Mindy\Base\Module;

class AntibankModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Surveys'),
                    'adminClass' => 'SurveyAdmin',
                ],
                [
                    'name' => self::t('Contact us'),
                    'adminClass' => 'ContactAdmin'
                ],
                [
                    'name' => self::t('Partner more'),
                    'adminClass' => 'MoreAdmin'
                ],
                [
                    'name' => self::t('Questions'),
                    'adminClass' => 'QuestionAdmin'
                ],
                [
                    'name' => self::t('Consultations'),
                    'adminClass' => 'ConsultAdmin'
                ],
                [
                    'name' => self::t('Partner requests'),
                    'adminClass' => 'PartnerAdmin'
                ],
                [
                    'name' => self::t('Partner advantages'),
                    'adminClass' => 'PartnerAdvantageAdmin'
                ]
            ]
        ];
    }
}
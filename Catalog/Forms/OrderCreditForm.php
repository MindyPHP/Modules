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
 * @date 22/08/14.08.2014 15:58
 */

namespace Modules\Catalog\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\CheckboxField;
use Mindy\Form\Fields\EmailField;
use Mindy\Form\Fields\LicenseField;
use Modules\Catalog\CatalogModule;

class OrderCreditForm extends OrderForm
{
    public $templateCode = 'catalog.order_credit';

    public function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'label' => CatalogModule::t('Name')
            ],
            'phone' => [
                'class' => CharField::className(),
                'required' => true,
                'label' => CatalogModule::t('Phone'),
                'html' => [
                    'class' => 'phone'
                ],
            ],
            'city' => [
                'class' => EmailField::className(),
                'required' => true,
                'label' => CatalogModule::t('City')
            ],
            'is_accepted' => [
                'class' => LicenseField::className(),
                'label' => CatalogModule::t('I agree to the processing of personal data'),
                'htmlLabel' => [
                    'data-url' => '#license',
                    'data-width' => 650,
                    'class' => 'mmodal'
                ]
            ]
        ];
    }
}

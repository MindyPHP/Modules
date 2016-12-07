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


use Exception;
use Mindy\Base\Mindy;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\EmailField;
use Mindy\Form\Fields\TextField;
use Mindy\Form\Form;
use Modules\Catalog\CatalogModule;

class OrderForm extends Form
{
    public $templateCode = 'catalog.order';

    public function getFields()
    {
        return [
            'name'=> [
                'class' => CharField::className(),
                'required' => true,
                'label' => CatalogModule::t('Name')
            ],
            'phone'=> [
                'class' => CharField::className(),
                'required' => true,
                'label' => CatalogModule::t('Phone'),
                'html' => [
                    'class' => 'phone'
                ],
            ],
            'email' => [
                'class' => EmailField::className(),
                'required' => true,
                'label' => CatalogModule::t('Email')
            ],
            'comment' => [
                'class' => TextField::className(),
                'label' => CatalogModule::t('Comment')
            ]
        ];
    }

    public function getFrom()
    {
        return $this->cleanedData['email'];
    }

    /**
     * Or use next code:
     *
     * Mindy::app()->mail
     * ->compose(['text' => $this->message])
     * ->setTo($this->email)
     * ->setSubject($this->subject)
     * ->send();
     *
     * @throws Exception
     * @return mixed
     */
    public function send()
    {
        if ($this->templateCode === null) {
            throw new Exception('$templateCode is null');
        }
        return Mindy::app()->mail->fromCode($this->templateCode, $this->getFrom(), [
            'data' => $this->cleanedData
        ]);
    }
}

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
 * @date 10/09/14.09.2014 12:49
 */

namespace Modules\Portfolio\Models;

use Mindy\Orm\Fields\AutoSlugField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\TreeModel;
use Modules\Portfolio\PortfolioModule;

class Category extends TreeModel
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => PortfolioModule::t('Name')
            ],
            'url' => [
                'class' => AutoSlugField::className(),
                'source' => 'name',
                'verboseName' => PortfolioModule::t('Url')
            ]
        ]);
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('portfolio.list', ['url' => $this->url]);
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = $this->getModule()->t('Categories');
        return $names;
    }
}

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
 * @date 19/02/15 07:02
 */
namespace Modules\Vacants\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\FileField;
use Mindy\Orm\Model;
use Modules\Vacants\VacantsModule;

class File extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Name')
            ],
            'code' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Code')
            ],
            'file' => [
                'class' => FileField::className(),
                'verboseName' => VacantsModule::t('File'),
                'types' => [
                    'pdf', 'doc', 'xls',
                    'docx', 'xlsx', 'jpg',
                    'png', 'jpeg', 'ppt'
                ]
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 
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
 * @date 26/03/15 11:19
 */
namespace Modules\CustomFields\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\CustomFields\Models\CustomField;
use Modules\CustomFields\Forms\CustomFieldForm;
use Modules\CustomFields\CustomFieldsModule;

class CustomFieldAdmin extends ModelAdmin
{
    public $linkColumn = 'name';

    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new CustomField;
    }
    
    public function getCreateForm()
    {
        return new CustomFieldForm;
    }
    
    public function getNames($model = null)
    {
        return [
            CustomFieldsModule::t('Custom fields'),
            CustomFieldsModule::t('Create custom field'),
            CustomFieldsModule::t('Update custom field')
        ];
    }
}
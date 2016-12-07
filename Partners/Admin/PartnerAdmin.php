<?php

namespace Modules\Partners\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Partners\Forms\PartnerForm;
use Modules\Partners\Models\Partner;
use Modules\Partners\PartnersModule;

class PartnerAdmin extends ModelAdmin
{
    public function getCreateForm()
    {
        return PartnerForm::className();
    }

    public function getColumns()
    {
        return ['id', 'name'];
    }

    public function getModel()
    {
        return new Partner();
    }

    public function getVerboseName()
    {
        return PartnersModule::t('partner');
    }

    public function getVerboseNamePlural()
    {
        return PartnersModule::t('partners');
    }
}


<?php

namespace Modules\Pages\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Pages\Forms\PagesForm;
use Modules\Pages\Models\Page;
use Modules\Pages\PagesModule;

/**
 * Class PageAdmin
 * @package Modules\Pages
 */
class PageAdmin extends Admin
{
    public $treeLinkColumn = 'name';

    public $columns = ['name'];

    public $searchFields = ['name', 'id'];

    public function getCreateForm()
    {
        return PagesForm::class;
    }

    /**
     * @return Page
     */
    public function getModelClass()
    {
        return Page::class;
    }

    public function getActions()
    {
        return array_merge(parent::getActions(), [
            'publish' => PagesModule::t('Publish'),
            'unpublish' => PagesModule::t('Unpublish'),
        ]);
    }

    public function actionUnpublish()
    {
        if (isset($_POST['models'])) {
            Page::objects()->filter(['pk' => $_POST['models']])->update(['is_published' => false]);
        }

        $this->getRequest()->redirect($this->getAdminUrl('list'));
    }

    public function actionPublish()
    {
        if (isset($_POST['models'])) {
            Page::objects()->filter(['pk' => $_POST['models']])->update(['is_published' => true]);
        }

        $this->getRequest()->redirect($this->getAdminUrl('list'));
    }
}


<?php

namespace Modules\Blog\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Blog\Forms\PostForm;
use Modules\Blog\Models\Post;
use Modules\Blog\BlogModule;

class PostAdmin extends Admin
{
    public $columns = ['name', 'published_at'];

    public $searchFields = ['name'];

    public function getCreateForm()
    {
        return PostForm::className();
    }

    public function getModelClass()
    {
        return Post::class;
    }

    public function getActions()
    {
        return array_merge(parent::getActions(), [
            'publish' => BlogModule::t('Publish'),
            'unpublish' => BlogModule::t('Unpublish'),
        ]);
    }

    public function actionUnpublish()
    {
        $cls = $this->getModelClass();
        if (isset($_POST['models'])) {
            $cls::objects()->filter(['pk' => $_POST['models']])->update(['is_published' => false]);
        }

        $this->getRequest()->redirect($this->getAdminUrl('list'));
    }

    public function actionPublish()
    {
        $cls = $this->getModelClass();
        if (isset($_POST['models'])) {
            $cls::objects()->filter(['pk' => $_POST['models']])->update(['is_published' => true]);
        }

        $this->getRequest()->redirect($this->getAdminUrl('list'));
    }
}


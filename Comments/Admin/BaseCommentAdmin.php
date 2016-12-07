<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 11/09/14.09.2014 17:52
 */

namespace Modules\Comments\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Comments\CommentsModule;

abstract class BaseCommentAdmin extends Admin
{
    public function getColumns()
    {
        return [
            'username',
            'email',
            'user',
            'created_at',
            'published_at',
            'is_spam',
            'is_published'
        ];
    }

    public function getActions()
    {
        return array_merge([
            'publish' => CommentsModule::t('Publish'),
            'unpublish' => CommentsModule::t('Unpublish'),
        ], parent::getActions());
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

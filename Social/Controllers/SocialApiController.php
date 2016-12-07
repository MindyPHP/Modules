<?php

namespace Modules\Social\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\ApiBaseController;
use Modules\Social\Models\SocialProfile;

class SocialApiController extends ApiBaseController
{
    public function actionIndex()
    {
        $models = SocialProfile::objects()->asArray()->filter([
            'user_id' => Mindy::app()->getUser()->pk
        ])->all();

        echo $this->json([
            'models' => $models
        ]);
        $this->end();
    }

    public function actionDelete()
    {
        $id = $this->getRequest()->post->get('id');
        if (empty($id)) {
            echo $this->json([
                'status' => false,
                'error' => 'Missing id'
            ]);
            $this->end();
        }

        $model = SocialProfile::objects()->get(['id' => $id]);
        if ($model === null) {
            $this->error(404);
        }

        $user = Mindy::app()->getUser();
        if ($model->user_id != $user->id) {
            echo $this->json([
                'status' => false,
                'error' => 'Access denied'
            ]);
            $this->end();
        }

        $status = (bool)$model->delete();
        echo $this->json([
            'status' => $status
        ]);
        $this->end();
    }
}

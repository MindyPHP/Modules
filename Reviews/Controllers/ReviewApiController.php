<?php


namespace Modules\Reviews\Controllers;

use Modules\Core\Controllers\ApiBaseController;
use Modules\Reviews\Forms\ReviewUserForm;
use Modules\Reviews\Models\Review;
use Modules\Reviews\ReviewsModule;

class ReviewApiController extends ApiBaseController
{
    public function actionIndex()
    {
        $models = Review::objects()
            ->filter(['is_published' => true])
            ->order(['-created_at'])
            ->asArray()
            ->all();

        echo $this->json([
            'models' => $models,
        ]);
        $this->end();
    }

    public function actionView($pk)
    {
        $model = Review::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        echo $this->json([
            'model' => $model
        ]);
        $this->end();
    }

    public function actionCreate()
    {
        $form = new ReviewUserForm();

        $r = $this->getRequest();
        if ($r->getIsPost() && $form->populate($_POST)->isValid() && $form->save()) {
            echo $this->json([
                'pk' => $form->getInstance()->pk,
                'success' => true,
                'message' => ReviewsModule::t('Review sucessfully sended')
            ]);
            $this->end();
        } else {
            echo $this->json([
                'errors' => $form->getJsonErrors()
            ]);
            $this->end();
        }
    }
}

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
 * @date 25/03/15 14:38
 */
namespace Modules\SortableMany\Controllers;

use Modules\Core\Controllers\BackendController;

class SortController extends BackendController
{
    public function actionSort()
    {
        $modelClass = $this->request->post->get('modelClass');
        $pkList = $this->request->post->get('pk', []);
        $primaryPk = $this->request->post->get('primaryKey');
        $primaryModelColumn = $this->request->post->get('primaryModelColumn');
        $modelColumn = $this->request->post->get('modelColumn');

        $counter = 1;
        if ($modelClass && $primaryPk && $primaryModelColumn && $modelColumn) {
            $modelClass::objects()->filter([$primaryModelColumn => $primaryPk])->delete();
            foreach ($pkList as $position => $pk) {
                $throughModel = new $modelClass();
                $throughModel->{$primaryModelColumn} = $primaryPk;
                $throughModel->{$modelColumn} = $pk;
                $throughModel->position = $counter;
                $throughModel->save();
                $counter++;
            }
        }
    }
}
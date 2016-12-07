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
 * @date 15/09/14.09.2014 15:13
 */

namespace Modules\Chained\Controllers;

use Modules\Core\Controllers\CoreController;

class ChainedController extends CoreController
{
    public function actionFeed()
    {
        if ($this->r->isAjax) {
            $modelClass = isset($_GET['modelClass']) ? $_GET['modelClass'] : null;
            $relatedBy = isset($_GET['relatedBy']) ? $_GET['relatedBy'] : null;
            $value = isset($_GET['value']) ? $_GET['value'] : null;
            $empty = isset($_GET['empty']) ? $_GET['empty'] : null;
            $order = isset($_GET['order']) ? $_GET['order'] : [];
            $data = [];
            if (!is_null($empty)) {
                $data[] = [
                    'pk'=> 0,
                    'value'=> $empty
                ];
            }
            if ($modelClass && $relatedBy && $value) {
                $qs = $modelClass::objects()->order($order)->filter([$relatedBy => $value]);
                foreach($qs->all() as $object) {
                    $data[] = [
                        'pk'=>$object->pk,
                        'value'=>(string)$object
                    ];
                }

            }
            echo json_encode($data);

        }else{
            $this->error(404);
        }
    }
}

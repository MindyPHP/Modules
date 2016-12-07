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

namespace Modules\Solutions\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Solutions\Forms\SolutionFilterForm;
use Modules\Solutions\Models\Solution;

class SolutionController extends CoreController
{
    public function actionIndex()
    {
        $form = new SolutionFilterForm;
        $filter = $this->filterGet($_GET, $form);

        $current_site = Mindy::app()->getModule('Sites')->getSite();
        if ($current_site->region_id && !isset($_GET['region'])) {
            $filter['region'] = $current_site->region_id;
        }

        $form->setAttributes($filter);

        $qs = Solution::objects()->order(['-created_at']);
        if (!empty($filter)) {
            $qs = $qs->filter($filter);
        }
        $pager = new Pagination($qs, [
            'pageSize' => 50
        ]);
        echo $this->render('solutions/index.html', [
            'models' => $pager->paginate(),
            'pager' => $pager,
            'form' => $form
        ]);
    }

    public function filterGet($request_array, $form)
    {
        $availiable = array_keys($form->getFieldsInit());;
        $filter = [];
        if (!empty($request_array)) {
            foreach($request_array as $key => $value) {
                if (in_array($key, $availiable)) {
                    if ($value == 0) {
                        continue;
                    }
                    $filter[$key] = $value;
                }
            }
        }
        return $filter;
    }

    public function actionView($pk)
    {
        $model = Solution::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }

        echo $this->render('solutions/view.html', [
            'model' => $model
        ]);
    }
}

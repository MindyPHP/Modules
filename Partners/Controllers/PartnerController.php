<?php

namespace Modules\Partners\Controllers;

use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Partners\Models\Partner;

class PartnerController extends CoreController
{
    public $defaultAction = 'list';

    public function actionList()
    {
        $pager = new Pagination(Partner::objects()->all());
        echo $this->render('partners/list.html', [
            'pager' => $pager,
            'partners' => $pager->paginate()
        ]);
    }
}

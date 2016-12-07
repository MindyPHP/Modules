<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 07/06/16 13:08
 */

namespace Modules\Geo\Controllers\Api;

use Mindy\Http\Request;
use Modules\Core\Actions\Index;
use Modules\Core\Controllers\FrontendController;
use Modules\Geo\Models\Country;

class CountryApiController extends FrontendController
{
    public function actions()
    {
        return [
            'autocomplete' => [
                'class' => Index::class,
                'modelClass' => Country::class,
                'pager' => false,
                'filter' => function (Request $request, $qs) {
                    /** @var \Mindy\Orm\Manager|\Mindy\Orm\QuerySet $qs */
                    $name = $request->get->get('name');
                    if (empty($name)) {
                        $this->error(404);
                    }
                    return $qs->filter([
                        'is_published' => true,
                        'name__icontains' => $name
                    ])->select([
                        'value' => 'name',
                        'label' => 'name',
                        'id' => 'id'
                    ]);
                }
            ]
        ];
    }
}
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
use Modules\Geo\Models\Region;

class RegionApiController extends FrontendController
{
    public function actions()
    {
        return [
            'autocomplete' => [
                'class' => Index::class,
                'modelClass' => Region::class,
                'pager' => false,
                'filter' => function (Request $request, $qs) {
                    /** @var \Mindy\Orm\Manager|\Mindy\Orm\QuerySet $qs */
                    $name = $request->get->get('name');
                    $countryId = $request->get->get('country_id');

                    if (empty($name)) {
                        $this->error(404);
                    }

                    if (empty($countryId) == false) {
                        $qs->filter(['country_id' => $countryId]);
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
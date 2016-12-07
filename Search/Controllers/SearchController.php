<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/10/14.10.2014 18:52
 */

namespace Modules\Search\Controllers;

use Elastica\Query;
use Elastica\Query\QueryString;
use Elastica\QueryBuilder;
use Mindy\Base\Mindy;
use Mindy\Helper\Meta;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Search\Components\ElasticQueryWrapper;

class SearchController extends CoreController
{
    public function actionSearch($type = null)
    {
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        $q = htmlspecialchars(str_replace(Meta::$punctuations, ' ', $q));

        $urlManager = Mindy::app()->urlManager;
        $module = $this->getModule();
        $tmp = $q ? ": " . $q : "";
        $this->addTitle($module->t('Search') . $tmp);
        $this->addBreadcrumb($module->t('Search') . $tmp, $urlManager->reverse('search:search'));

        $results = [];
        if (!empty($q)) {
            $query = new Query();
            $query->setQuery(new QueryString($q));
            $query->setSort(['type' => 'asc']);

            $search = $this->getModule()->getSearchIndex();
            if ($type !== null) {
                $search = $search->getType($type);
            }
            $results = new ElasticQueryWrapper($search, $query);
        }

        $pager = new Pagination($results);
        echo $this->render('search/list.html', [
            'results' => $pager->paginate(),
            'pager' => $pager,
        ]);
    }

    protected function getClient()
    {
        return $this->getModule()->getClient();
    }
}

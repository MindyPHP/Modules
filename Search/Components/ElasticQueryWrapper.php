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
 * @date 11/11/14.11.2014 16:18
 */

namespace Modules\Search\Components;

use Elastica\Query;
use Mindy\Pagination\Interfaces\IPagination;

class ElasticQueryWrapper implements IPagination
{
    /**
     * @var \Elastica\Index
     */
    public $index;
    /**
     * @var \Elastica\Query
     */
    public $query;
    /**
     * @var \Elastica\ResultSet
     */
    public $result;

    public function __construct($index, Query $query)
    {
        $this->index = $index;
        $this->query = $query;
    }

    /**
     * @param $limit int
     * @return $this
     */
    public function setLimit($limit)
    {
        if ($limit) {
            $this->query->setSize($limit);
        }
        return $this;
    }

    /**
     * @param $offset int
     * @return $this
     */
    public function setOffset($offset)
    {
        if ($offset) {
            $this->query->setFrom($offset);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        try {
            return $this->result = $this->index->search($this->query);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getTotal()
    {
        try {
            return $this->index->search($this->query)->getTotalHits();
        } catch (\Exception $e) {
            return 0;
        }
    }
}

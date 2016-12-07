<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 18/09/14
 * Time: 09:43
 */

namespace Modules\Solutions\Helpers;


use Modules\Solutions\Models\Solution;

class SolutionHelper
{
    public static function getSolutions($limit = 15)
    {
        $solutions = Solution::objects()->filter(['status' => Solution::STATUS_COMPLETE])->order(['-created_at'])->limit($limit)->all();
        return $solutions;
    }

    public static function countSolutions()
    {
        $solutions = Solution::objects()->filter(['status' => Solution::STATUS_COMPLETE])->count();
        return $solutions;
    }
} 
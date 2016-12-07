<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 12/05/16 09:47
 */

namespace Modules\Statistics\Library;

use Mindy\Base\Mindy;
use Mindy\Template\Library;
use Modules\Statistics\Models\Statistics;

class StatisticsLibrary extends Library
{
    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'grab_statistics' => function() {
                $request = Mindy::app()->request;
                $request->getPath();
                $adminRoute = Mindy::app()->urlManager->reverse('admin:index');
                $isAdmin = strpos($request->getPath(), $adminRoute) === 0;
                if ($isAdmin === false) {
                    (new Statistics([
                        'user_agent' => $request->http->getUserAgent(),
                        'ip_address' => $request->http->getUserHostAddress(),
                        'url' => $request->getPath()
                    ]))->save();
                }
            }
        ];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return [];
    }
}
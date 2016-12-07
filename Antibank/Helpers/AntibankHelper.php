<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 18/09/14
 * Time: 17:48
 */

namespace Modules\Antibank\Helpers;


use Mindy\Base\Mindy;
use Modules\Antibank\Forms\FeedbackForm;
use Modules\Antibank\Models\Office;
use Modules\Antibank\Models\PartnerAdvantage;

class AntibankHelper
{
    public static function getCurrentSiteOffices()
    {
        $site = Mindy::app()->getModule('Sites')->getSite();
        $offices = Office::objects()->filter(['site' => $site])->all();
        return $offices;
    }

    public static function getAdvantages()
    {
        return PartnerAdvantage::objects()->order(['position'])->all();
    }

    public static function getQuestionForm()
    {
        return new FeedbackForm();
    }
} 
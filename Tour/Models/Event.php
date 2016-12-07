<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 17/02/15 15:14
 */
namespace Modules\Tour\Models;

use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\Tour\Models\Order;
use Modules\Tour\TourModule;

class Event extends Model
{
    public static function getFields() 
    {
        return [
            'place' => [
                'class' => ForeignField::className(),
                'modelClass' => Place::className(),
                'verboseName' => TourModule::t('Place')
            ],
            'datetime' => [
                'class' => DatetimeField::className(),
                'verboseName' => TourModule::t('Datetime')
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string) $this->place->name . ' ' . date('d.m.Y H:i', strtotime($this->datetime));
    }

    public static function getCalendar($place, $month, $year, $excludeUnusable = true)
    {
        $firstTime = mktime(0,0,0,$month,1,$year);
        $lastDay = date('t', $firstTime);
        $lastTime = mktime(23,59,59,$month,$lastDay,$year);

        $eventsQs = self::objects()->filter([
            'datetime__gte' => $excludeUnusable ? date('Y-m-d H:i:s', strtotime('+1 hour')) : date('Y-m-d H:i:s', $firstTime),
            'datetime__lte' => date('Y-m-d H:i:s', $lastTime),
            'place_id' => $place
        ])->order(['datetime']);

        if ($excludeUnusable) {
            $ordered = Order::objects()->valuesList(['event_id'], true);
            $eventsQs = $eventsQs->exclude([
                'id__in' => $ordered
            ]);
        }
        $eventsRaw = $eventsQs->all();

        $events = [];
        foreach ($eventsRaw as $event) {
            $date = date('d.m.Y', strtotime($event->datetime));
            if (!isset($events[$date])) {
                $events[$date] = [];
            }
            $events[$date][] = $event;
        }
        $firstWeekDay = date('N', $firstTime);

        $weeks = [];
        $days = [];

        /* First line */
        for ($i=0;$i<$firstWeekDay-1;$i++) {
            $days[] = [];
        }

        /* Current month */
        for ($i=1;$i<=$lastDay;$i++) {
            $date = date('d.m.Y', mktime(0,0,0,$month,$i,$year));
            $days[] = [
                'date' => $date,
                'events' => isset($events[$date]) ? $events[$date] : []
            ];
            if (count($days) == 7) {
                $weeks[] = $days;
                $days = [];
            }
        }

        /* Empty days */
        for ($i=count($days);$i<7;$i++) {
            $days[] = [];
        }
        $weeks[] = $days;
        return $weeks;
    }

    public function order()
    {
        return Order::objects()->filter(['event_id' => $this->id])->get();
    }
} 
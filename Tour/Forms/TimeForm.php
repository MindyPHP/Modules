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
 * @date 18/02/15 07:06
 */
namespace Modules\Tour\Forms;

use Mindy\Form\Fields\DropDownField;
use Mindy\Form\Form;
use Mindy\Form\Fields\CharField;
use Modules\Tour\Models\Event;
use Modules\Tour\TourModule;

class TimeForm extends Form
{
    public function getFields()
    {
        $hours = [];
        $minutes = [];
        for($i=6;$i<=22;$i++) {$hours[$i] = sprintf('%1$02d', $i);};
        for($i=0;$i<=55;$i+=5) {$minutes[$i] = sprintf('%1$02d', $i);};
        return [
            'hour' => [
                'class' => DropDownField::className(),
                'choices' => $hours
            ],
            'minute' => [
                'class' => DropDownField::className(),
                'choices' => $minutes
            ]
        ];
    }

    public function save($place, $month, $year, $day)
    {
        $cleaned = $this->cleanedData;
        $time = mktime($cleaned['hour'], $cleaned['minute'], 0, $month,$day,$year);
        $date = date('Y-m-d H:i:s', $time);
        if (Event::objects()->filter(['datetime' => $date, 'place_id' => $place])->count() == 0) {
            $event = new Event();
            $event->place_id = $place;
            $event->datetime = $date;
            return $event->save();
        } else {
            $this->addError('hour', TourModule::t('This time is busy!'));
            return false;
        }
    }
}
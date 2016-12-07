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
 * @date 17/02/15 16:16
 */
namespace Modules\Tour\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Tour\Forms\OrderForm;
use Modules\Tour\Forms\TimeForm;
use Modules\Tour\Models\Event;
use Modules\Tour\Models\Order;
use Modules\Tour\Models\Place;
use Modules\Tour\TourModule;

class TourController extends CoreController
{
    public function actionIndex($place = null, $month = null, $year = null)
    {
        $placesRaw = Place::objects()->all();
        $places = [];
        foreach($placesRaw as $placeRaw) {
            $places[$placeRaw->id] = $placeRaw;
        }

        if (!$month) $month = date('m');
        if (!$year) $year = date('Y');
        if (!$place) $place = array_values($places)[0]->id;

        if ($month < 1 || $month > 12) {
            $this->error(404);
        }
        if ($year < date('Y') - 1 || $year > date('Y') + 2) {
            $this->error(404);
        }

        if (!array_key_exists($place, $places)) {
            $this->error(404);
        }
        $calendar = Event::getCalendar($place, $month, $year, !Mindy::app()->user->is_superuser);

        $form = new OrderForm();
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->flash->success(TourModule::t('Success order!'));
            $this->redirect($this->r->getPath());
        }

        $prevUrl = Mindy::app()->urlManager->reverse('tour:month', [$place, $month - 1, $year]);
        if ($month == 1) {
            $prevUrl = Mindy::app()->urlManager->reverse('tour:month', [$place, 12, $year - 1]);
        }
        $nextUrl = Mindy::app()->urlManager->reverse('tour:month', [$place, $month + 1, $year]);
        if ($month == 12) {
            $nextUrl = Mindy::app()->urlManager->reverse('tour:month', [$place, 1, $year + 1]);
        }

        echo $this->render('tour/index.html', [
            'calendar' => $calendar,
            'place_id' => $place,
            'month' => $month,
            'year' => $year,
            'places' => $places,
            'form' => $form,
            'first_date' => mktime(0,0,0,$month,1,$year),
            'prev_url' => $prevUrl,
            'next_url' => $nextUrl,
            'today' => date('d.m.Y')
        ]);
    }

    public function actionAppend($place, $month, $year, $day)
    {
        if (!Mindy::app()->user->is_superuser) {
            $this->error(404);
        }
        $time = mktime(0,0,0,$month,$day,$year);

        $form = new TimeForm();

        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save($place, $month, $year, $day)) {
            echo $this->render('tour/time_success.html');
            Mindy::app()->end();
        }

        echo $this->render('tour/time_form.html', [
            'form' => $form,
            'time' => $time,
            'place' => $place,
            'month' => $month,
            'year' => $year,
            'day' => $day
        ]);
    }

    public function actionDelete()
    {
        if (!Mindy::app()->user->is_superuser) {
            $this->error(404);
        }
        if (isset($_POST['id'])) {
            var_dump($_POST['id']);
            var_dump(Event::objects()->filter(['id' => $_POST['id']])->get());
            Event::objects()->filter(['id' => $_POST['id']])->delete();
        }
    }

    public function actionOrder($id)
    {
        if (!Mindy::app()->user->is_superuser) {
            $this->error(404);
        }
        $model = $this->getOr404(new Order(), $id);
        echo $this->render('tour/order.html', [
            'model' => $model
        ]);
    }
} 
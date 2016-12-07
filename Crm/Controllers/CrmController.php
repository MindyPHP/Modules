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
 * @date 03/10/14 09:41
 */
namespace Modules\Crm\Controllers;

use DateTime;
use DateInterval;

use Mindy\Base\Mindy;
use Mindy\Locale\DateFormatter;
use Modules\Core\Controllers\CoreController;
use Modules\Crm\Models\Payment;
use Modules\Crm\Models\PayRequest;
use Modules\Crm\Models\Project;
use Modules\Crm\Models\Subscribe;
use TCPDF;

class CrmController extends CoreController
{
    public $dateFrom = null;
    public $dateTo = null;

    public function getActionsList()
    {
        $formatter = new DateFormatter('ru_RU');
        $actions = [];
        $date = new DateTime();

        for ($i=0;$i<3;$i++) {
            $url = Mindy::app()->urlManager->reverse('crm.account', [$date->format('Y-m-d')]);
            $name = 'Счета за '.$formatter->format('LLLL',$date->getTimestamp());

            $actions[$url] = $name;
            $date->sub(DateInterval::createFromDateString('1 month'));
        }

        $date = new DateTime();

        for ($i=0;$i<3;$i++) {
            $url = Mindy::app()->urlManager->reverse('crm.act', [$date->format('Y-m-d')]);
            $name = 'Акты за '.$formatter->format('LLLL',$date->getTimestamp());

            $actions[$url] = $name;
            $date->sub(DateInterval::createFromDateString('1 month'));
        }

        return $actions;
    }

    public function actionIndex()
    {
        if (isset($_GET['dateTo'])) {
            $this->dateTo = $_GET['dateTo'];
        }
        $projects = $this->getProjects();
        $months = $this->getMonths();
        foreach ($months as $key => $month) {
            $months[$key]['expected'] = Subscribe::monthExpected($month['month'], $month['year']);
            $months[$key]['collected'] = Payment::monthCollected($month['month'], $month['year']);
        }

        list($prev, $next) = $this->getNextPrevLinks();
        echo $this->render('crm/index.html', [
            'projects' => $projects,
            'months' => $months,
            'prev' => $prev,
            'next' => $next,
            'actions' => $this->getActionsList()
        ]);
    }

    public function getNextPrevLinks($count = 6)
    {
        $first = clone $this->dateFrom;
        $last = clone $this->dateTo;

        return [
            $first->sub(DateInterval::createFromDateString('1 months'))->format('Y-m-d'),
            $last->add(DateInterval::createFromDateString($count . ' months'))->format('Y-m-d')
        ];
    }

    public function actionPay()
    {
        $subscribe = isset($_POST['subscribe']) ? $_POST['subscribe'] : null;
        $month = isset($_POST['month']) ? $_POST['month'] : null;
        $year = isset($_POST['year']) ? $_POST['year'] : null;
        $payment = isset($_POST['payment']) ? $_POST['payment'] : null;

        if ($month && $year && $subscribe) {
            if ($payment) {
                $payment = Payment::objects()->get(['pk' => $payment]);
                if ($payment) {
                    $payment->delete();
                }
            } else {
                $payment = new Payment([
                    'subscribe_id' => $subscribe,
                    'month' => $month,
                    'year' => $year
                ]);
                $payment->save();
            }
        }
    }

    public function actionRequest()
    {
        $subscribe = isset($_POST['subscribe']) ? $_POST['subscribe'] : null;
        $month = isset($_POST['month']) ? $_POST['month'] : null;
        $year = isset($_POST['year']) ? $_POST['year'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;

        $request = isset($_POST['request']) ? $_POST['request'] : null;

        if ($month && $year && $subscribe) {
            if ($request) {
                $request = PayRequest::objects()->get(['pk' => $request]);
                if ($request) {
                    if ($status) {
                        $request->status = $status;
                        $request->save();
                    } else {
                        $request->delete();
                    }
                }
            } else {
                $request = new PayRequest([
                    'subscribe_id' => $subscribe,
                    'month' => $month,
                    'year' => $year,
                    'status' => $status ? $status : PayRequest::STATUS_SENT
                ]);
                $request->save();
            }
        }
    }

    public function actionProject($pk)
    {
        $project = Project::objects()->get(['pk' => $pk]);
        if (!$project) {
            $this->error(404);
        }
        $acts = PayRequest::objects()->filter(['subscribe__project' => $project])->asArray()->all();
        $pays = Payment::objects()->filter(['subscribe__project' => $project])->asArray()->all();

        $actions = $this->actionsByDate($acts, $pays);

        $dates = [];
        $date = new DateTime();
        for ($i=0;$i<10;$i++) {
            $dates[] = clone $date;
            $date->sub(DateInterval::createFromDateString('1 months'));
        }

        list($debts, $debtSum, $debtMonths) = $project->getDebts();

        echo $this->render('crm/project.html',[
            'project' => $project,
            'actions' => $actions,
            'dates' => $dates,
            'debts' => $debts,
            'debtSum' => $debtSum,
            'debtMonths' => $debtMonths,
            'formatter' => new DateFormatter('ru_RU')
        ]);
    }

    public function actionsByDate($acts, $pays)
    {
        $actions = [];
        foreach($acts as $act) {
            $date = new DateTime($act['created_at']);
            if (!isset($actions[$date->format('Y-m-d')])) {
                $actions[$date->format('Y-m-d')] = [];
            }
            $act['verbose'] = 'Отправлен акт';
            $dateAction = new DateTime();
            $act['date'] = $dateAction->setDate($act['year'], $act['month'], 1);
            $actions[$date->format('Y-m-d')][] = $act;

            if ($act['status'] == PayRequest::STATUS_RECEIVED) {
                $date = new DateTime($act['updated_at']);
                if (!isset($actions[$date->format('Y-m-d')])) {
                    $actions[$date->format('Y-m-d')] = [];
                }
                $act['verbose'] = 'Получен акт';
                $dateAction = new DateTime();
                $act['date'] = $dateAction->setDate($act['year'], $act['month'], 1);
                $actions[$date->format('Y-m-d')][] = $act;
            }
        }

        foreach($pays as $pay) {
            $date = new DateTime($pay['created_at']);
            if (!isset($actions[$date->format('Y-m-d')])) {
                $actions[$date->format('Y-m-d')] = [];
            }
            $pay['verbose'] = 'Оплачен счет';
            $dateAction = new DateTime();
            $pay['date'] = $dateAction->setDate($pay['year'], $pay['month'], 1);
            $actions[$date->format('Y-m-d')][] = $pay;
        }

        krsort($actions);

        return $actions;
    }

    public function getMonths($count = 6)
    {
        $months = [];
        if (!$this->dateFrom) {
            if ($this->dateTo) {
                $this->dateTo = new DateTime($this->dateTo);
            } else {
                $this->dateTo = new DateTime();
            }
            $date = clone $this->dateTo;
            $date->sub(DateInterval::createFromDateString($count - 1 . ' months'));
            $this->dateFrom = clone $date;
        } else {
            $date = clone $this->dateFrom;
        }

        while ($count > 0) {
            $months[] = [
                'month' => $date->format('n'),
                'year' => $date->format('Y'),
                'full' => $date->format('Y') . '-' . $date->format('m')
            ];
            $date->add(DateInterval::createFromDateString('1 month'));
            $count--;
        }

        return $months;
    }

    public function getSubscriptions()
    {
        $qs = Subscribe::objects()
            ->filter(['to__gte' => $this->dateFrom->format('Y-m-01'), 'from__lte' => $this->dateTo->format('Y-m-t')]);

        $subscribes = $qs->asArray()->all();
        $prepared = [];
        $pks = [];
        foreach ($subscribes as $subscribe) {
            $project = $subscribe['project_id'];
            if (!isset($prepared[$project])) {
                $prepared[$project] = [];
            }
            $preparedSubscribe = $subscribe;
            $preparedSubscribe['start'] = substr($subscribe['from'], 0, 7);
            $preparedSubscribe['stop'] = substr($subscribe['to'], 0, 7);
            $pks[] = $subscribe['id'];
            $prepared[$project][] = $preparedSubscribe;
        }
        return [$prepared, $pks];
    }

    public function getPayments($subscribes_pk)
    {
        return Payment::prepared(['subscribe_id__in' => $subscribes_pk]);
    }

    public function getRequests($subscribes_pk)
    {
        return PayRequest::prepared(['subscribe_id__in' => $subscribes_pk]);
    }

    public function getProjects()
    {
        $projects = Project::objects()->asArray()->all();

        $months = $this->getMonths();
        list($subscribes, $subscribes_pk) = $this->getSubscriptions();
        $payments = $this->getPayments($subscribes_pk);
        $requests = $this->getRequests($subscribes_pk);

        $preparedProjects = [];

        foreach ($projects as $project) {

            $id = $project['id'];
            $projectSubscribes = isset($subscribes[$id]) ? $subscribes[$id] : [];
            $preparedProject = $project;

            if ($projectSubscribes) {
                $preparedProject['months'] = [];

                foreach ($months as $month) {
                    $subscribe = null;
                    $full = $month['full'];

                    foreach ($projectSubscribes as $projectSubscribe) {
                        if ($projectSubscribe['start'] <= $full && $projectSubscribe['stop'] >= $full) {
                            $subscribe = $projectSubscribe;
                            break;
                        }
                    }

                    $preparedProject['months'][$full] = [
                        'subscribe' => null,
                        'payment' => null,
                        'request' => null,
                        'month' => $month
                    ];

                    if ($subscribe) {
                        $subscribeId = $subscribe['id'];
                        $preparedProject['months'][$full]['subscribe'] = $subscribe;

                        $subscriptionPayments = isset($payments[$subscribeId]) ? $payments[$subscribeId] : [];
                        if ($subscriptionPayments && isset($subscriptionPayments[$full])) {
                            $preparedProject['months'][$full]['payment'] = $subscriptionPayments[$full];
                        }

                        $subscriptionRequests = isset($requests[$subscribeId]) ? $requests[$subscribeId] : [];
                        if ($subscriptionRequests && isset($subscriptionRequests[$full])) {
                            $preparedProject['months'][$full]['request'] = $subscriptionRequests[$full];
                        }
                    }
                }

                $preparedProjects[] = $preparedProject;
            }
        }

        return $preparedProjects;
    }

    public function actionAccount($date = null)
    {
        $this->pdf($date, 'account');
    }

    public function actionAct($date = null)
    {
        $this->pdf($date, 'act');
    }

    public function pdf($date = null, $type = 'account')
    {
        $ids = isset($_GET['projects']) ? $_GET['projects'] : [];
        $date = new DateTime($date);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetFont('dejavusans', '', 10, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10,0,15);

        foreach($ids as $id) {
            $pdf->AddPage();
            $project = Project::objects()->get(['pk' => $id]);
            if ($project) {
                list($subscription, $number) = $project->currentSubscription($date->format('m'), $date->format('Y'));
                $html = $this->render("crm/{$type}.html", [
                    'project' => $project,
                    'subscription' => $subscription,
                    'num' => $number,
                    'formatter' => new DateFormatter('ru_RU'),
                    'date' => $date
                ]);
                $pdf->writeHTML($html, true, false, true, false, '');
            }
        }

        $pdf->Output("{$type}s_{$date->format('d.m.Y')}.pdf", 'I');
    }
} 
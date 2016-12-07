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
 * @date 03/10/14 08:36
 */

namespace Modules\Crm\Models;

use DateInterval;
use DateTime;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\Crm\CrmModule;
use Mindy\Orm\Fields\DateField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;

class Project extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => CrmModule::t('Project name')
            ],
            'client' => [
                'class' => ForeignField::className(),
                'modelClass' => Client::className(),
                'required' => true,
                'verboseName' => CrmModule::t('Client')
            ],
            'date_contract' => [
                'class' => DateField::className(),
                'verboseName' => CrmModule::t('Date contract')
            ],
            'number_contract' => [
                'class' => IntField::className(),
                'verboseName' => CrmModule::t('Date number')
            ],
            'customer_fullname' => [
                'class' => TextField::className(),
                'verboseName' => CrmModule::t('Customer full name')
            ],
            'customer_name' => [
                'class' => CharField::className(),
                'verboseName' => CrmModule::t('Customer short name (act signature)')
            ],

            'inn' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('INN')
            ],
            'kpp' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('KPP')
            ],
            'ogrn' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('OGRN')
            ],
            'legal_address' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('Legal address')
            ],
            'post_address' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('Post address')
            ],
            'email' => [
                'class' => EmailField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('E-mail')
            ],
            'phone' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('Phone')
            ],
            'settlement_account' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('Settlement account')
            ],
            'bank_name' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('Bank name')
            ],
            'bank_account' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('Correspondent account')
            ],
            'bik' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CrmModule::t('BIK')
            ],

            'details' => [
                'class' => TextField::className(),
                'verboseName' => CrmModule::t('Details')
            ],
        ];
    }
    
    public function __toString() 
    {
        return $this->name;
    }

    public function currentSubscription($month, $year)
    {
        $date = new DateTime();
        $date->setDate($year, $month, 15);
        $subscription = Subscribe::objects()->filter([
            'project' => $this,
            'from__lte' => $date->format('Y-m-d'),
            'to__gte' => $date->format('Y-m-d')
        ])->limit(1)->get();
        if ($subscription) {
            $dateFrom = new DateTime($subscription->from);
            $months = $dateFrom->diff($date)->m;
            $num = $subscription->num_from + $months;
            return [$subscription, $num];
        }else{
            return [null, null];
        }
    }

    public function getDebts()
    {
        $payments = Payment::prepared(['subscribe__project' => $this]);
        $requests = PayRequest::prepared(['subscribe__project' => $this]);
        $subscriptions = Subscribe::objects()->filter(['project' => $this])->asArray()->all();

        $debts = [];
        $debtSum = 0;
        $debtMonths = 0;

        $to = new DateTime();

        foreach($subscriptions as $subscribe) {
            $date = new DateTime($subscribe['from']);

            $subId = $subscribe['id'];
            while ($date < $to) {
                // Payments
                if (!isset($payments[$subId]) || !isset($payments[$subId][$date->format('Y-m')])) {
                    if (!isset($debts[$date->format('Y-m-01')])) {
                        $debts[$date->format('Y-m-01')] = [];
                    }
                    $debts[$date->format('Y-m-01')][] = [
                        'name' => 'Нет платежа',
                        'action' => 'account'
                    ];
                    $debtSum += $subscribe['price'];
                    $debtMonths += 1;
                }

                // Requests
                if (!isset($requests[$subId]) || !isset($requests[$subId][$date->format('Y-m')])) {
                    if (!isset($debts[$date->format('Y-m-01')])) {
                        $debts[$date->format('Y-m-01')] = [];
                    }
                    $debts[$date->format('Y-m-01')][]  = [
                        'name' => 'Акт не отправлен',
                        'action' => 'act'
                    ];
                }elseif ($requests[$subId][$date->format('Y-m')]['status'] == PayRequest::STATUS_SENT){
                    if (!isset($debts[$date->format('Y-m-01')])) {
                        $debts[$date->format('Y-m-01')] = [];
                    }
                    $debts[$date->format('Y-m-01')][] = [
                        'name' => 'Акт не получен',
                        'action' => 'act'
                    ];
                }

                $date->add(DateInterval::createFromDateString('1 month'));
            }
        }

        krsort($debts);

        return [$debts, $debtSum, $debtMonths];
    }
} 
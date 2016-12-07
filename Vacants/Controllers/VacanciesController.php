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
 * @date 19/02/15 07:06
 */
namespace Modules\Vacants\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Vacants\Forms\ResponseForm;
use Modules\Vacants\Models\Department;
use Modules\Vacants\Models\Vacancy;
use Modules\Vacants\VacantsModule;

class VacanciesController extends CoreController
{
    public function actionIndex()
    {
        $vacancies = Vacancy::objects()->all();
        $departmentsPkList = Vacancy::objects()->distinct()->valuesList(['department_id'], true);
        $departments = Department::objects()->order(['position'])->filter(['id__in' => $departmentsPkList])->all();

        echo $this->render('vacants/index.html', [
            'departments' => $departments,
            'vacancies' => $vacancies
        ]);
    }

    public function actionResponse()
    {
        $form = new ResponseForm();
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            if ($this->r->isAjax) {
                echo $this->render('vacants/success.html');
                Mindy::app()->end();
            } else {
                $this->r->flash->success(VacantsModule::t('Response successfully sent'));
                $this->r->refresh();
            }
        }

        echo $this->render('vacants/response_form.html', [
            'form' => $form
        ]);
    }
} 
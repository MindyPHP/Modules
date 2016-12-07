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
 * @date 14/11/14 10:16
 */
namespace Modules\Workers\Controllers;

use Modules\Core\Controllers\CoreController;
use Modules\Workers\Models\Department;
use Modules\Workers\Models\Worker;
use Modules\Workers\WorkersModule;

class DepartmentController extends CoreController
{
    public function actionList()
    {
        $departments = Department::objects()->order(['position'])->all();
        $data = [];
        $departmentHead = Worker::objects()->filter(['is_head' => true])->order(['position'])->all();

        foreach($departments as $department){
            $data[$department->pk] = [
                'department'=> $department,
                'list_workers' =>  Worker::objects()->filter(['departments__id__in' => $department->pk, 'is_published' => true])->order(['-is_head', 'position'])->all(),
            ];
        }
        echo $this->render('workers/department/list.html', [
            'departments' => $data,
            'departmentHead'=> $departmentHead
        ]);
    }
}

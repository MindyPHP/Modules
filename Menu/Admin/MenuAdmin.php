<?php

namespace Modules\Menu\Admin;

use Mindy\Orm\Model;
use Modules\Admin\Admin\Admin;
use Modules\Admin\AdminModule;
use Modules\Menu\Forms\MenuForm;
use Modules\Menu\Models\Menu;

class MenuAdmin extends Admin
{
    /**
     * @var string
     */
    public $treeLinkColumn = 'name';

    public function getRedirectParams($action)
    {
        switch ($action) {
            case "save_create":
                return ['parent' => 'parent_id'];
            case "save":
                return ['parent' => 'pk'];
            default:
                return [];
        }
    }

    public function getInitialAttributes()
    {
        return [
            'parent' => $_GET['parent_id'] ?? null
        ];
    }

    public function getCustomBreadrumbs(Model $model, $action)
    {
        $breadcrumbs = [];

        if ($model->getIsNewRecord()) {
            if (isset($_GET['parent_id'])) {
                $model = Menu::objects()->get(['id' => $_GET['parent_id']]);
                if ($model === null) {
                    return [];
                }
            } else {
                return [];
            }
        }

        $parents = $model->objects()->ancestors(true)->order(['lft'])->all();
        foreach ($parents as $ancestor) {
            $breadcrumbs[] = [
                'name' => (string)$ancestor,
                'url' => $this->getAdminUrl('list') . '?' . http_build_query(['pk' => $ancestor->id])
            ];
        }

        return $breadcrumbs;
    }

    public function getSearchFields()
    {
        return ['name'];
    }

    public function getColumns()
    {
        return ['name', 'slug', 'url'];
    }

    public function getCreateForm()
    {
        return MenuForm::class;
    }

    public function getModelClass()
    {
        return Menu::class;
    }
}

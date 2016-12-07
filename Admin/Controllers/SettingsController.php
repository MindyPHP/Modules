<?php

namespace Modules\Admin\Controllers;

use Mindy\Base\Mindy;
use Mindy\Helper\Alias;
use Modules\Core\Controllers\BackendController;
use Modules\Core\CoreModule;
use Modules\Core\Forms\SettingsForm;

class SettingsController extends BackendController
{
    public function accessRules()
    {
        return [
            // allow only authorized users
            [
                'allow' => true,
                'users' => ['@'],
                'expression' => function ($user) {
                    return (bool)($user->is_superuser || $user->can('core.change_settings'));
                }
            ],
        ];
    }

    protected function getSettingsModels()
    {
        $modulesPath = Alias::get('Modules');
        $modules = Mindy::app()->modules;
        $modelsPath = [];
        foreach ($modules as $name => $params) {
            $tmpPath = $modulesPath . '/' . $name . '/Models/';
            $paths = glob($tmpPath . '*Settings.php');
            if (!array_key_exists($name, $modelsPath)) {
                $modelsPath[$name] = [];
            }

            if (is_array($paths)) {
                $modelsPath[$name] = array_merge($modelsPath[$name], array_map(function ($path) use ($name, $tmpPath) {
                    return 'Modules\\' . $name . '\\Models\\' . str_replace('.php', '', str_replace($tmpPath, '', $path));
                }, $paths));
            }
        }
        return $modelsPath;
    }

    protected function reformatModels(array $moduleModels)
    {
        $models = [];
        foreach ($moduleModels as $tmpModels) {
            foreach ($tmpModels as $modelClass) {
                $model = $modelClass::getInstance();
                $models[$modelClass] = [
                    'model' => $model,
                    'form' => new SettingsForm(['model' => $model, 'instance' => $model])
                ];
            }
        }
        return $models;
    }

    public function actionIndex()
    {
        $models = $this->reformatModels($this->getSettingsModels());
        $request = $this->getRequest();

        if ($request->isPost) {
            $success = true;
            foreach ($models as $data) {
                $form = $data['form'];
                if (($form->populate($_POST, $_FILES)->isValid() && $form->save()) === false) {
                    $success = false;
                }
            }
            if ($success) {
                $request->flash->success($this->getModule()->t('Settings successfully saved'));
                $request->refresh();
            } else {
                $request->flash->error($this->getModule()->t('Failed to save settings'));
            }
        }

        echo $this->render('admin/settings.html', [
            'models' => $models,
        ]);
    }
}

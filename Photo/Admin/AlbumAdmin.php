<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/08/14.08.2014 12:53
 */

namespace Modules\Photo\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Photo\PhotoModule;
use Modules\Photo\Forms\AlbumForm;
use Modules\Photo\Models\Album;

class AlbumAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }

    public function getCreateForm()
    {
        return AlbumForm::className();
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Album;
    }

    public function getVerboseName()
    {
        return PhotoModule::t('album');
    }

    public function getVerboseNamePlural()
    {
        return PhotoModule::t('albums');
    }
}

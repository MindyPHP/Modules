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
 * @date 09/09/14.09.2014 10:31
 */

namespace Modules\Video\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Video\Forms\VideoForm;
use Modules\Video\Models\Video;

class VideoAdmin extends Admin
{
    public $columns = ['name', 'url', 'category'];

    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Video::class;
    }

    public function getCreateForm()
    {
        return VideoForm::class;
    }
}

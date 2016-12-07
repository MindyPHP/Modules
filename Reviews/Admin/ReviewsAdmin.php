<?php

namespace Modules\Reviews\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Reviews\Forms\ReviewAdminForm;
use Modules\Reviews\Models\Review;

class ReviewsAdmin extends Admin
{
    public $columns = ['name', 'email', 'published_at'];

    public function getCreateForm()
    {
        return ReviewAdminForm::class;
    }

    public function getModelClass()
    {
        return Review::class;
    }
}


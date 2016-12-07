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
 * @date 14/10/14.10.2014 18:44
 */

namespace Modules\Forum\Forms;

use Mindy\Form\ModelForm;
use Modules\Forum\Models\Post;

class PostForm extends ModelForm
{
    public $exclude = ['topic'];

    public function getModel()
    {
        return new Post;
    }
}

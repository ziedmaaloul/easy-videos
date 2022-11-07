<?php

namespace App\Traits;
use \TypeRocket\Template\View;

trait ViewTrait
{

    protected $resourcesPath = EASY_VIDEOS_PATH.'/resources/view';


    // Extended Render view to get view from current Plugin
    public static function viewRender($dots, array $data = [], $ext = '.php')
    {
        return View::new($dots,$data , $ext, EASY_VIDEOS_PATH.'/resources/view');
    }
}

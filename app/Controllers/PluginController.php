<?php

namespace App\Controllers;


class PluginController
{

    public function createPostType()
    {
        // Create Video post Type and set only for Admin
        $easyVideo = tr_post_type('Video')->setAdminOnly();
       
    }
}

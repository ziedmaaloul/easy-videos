<?php

namespace App\Controllers;
use \App\Controllers\YoutubeController;
use \App\Controllers\VideoController;
use App\Traits\ViewTrait;


class PluginController
{
    use ViewTrait;


    protected $youtubeController = null;
    protected $videoController = null;


    public function __construct(){
        $this->youtubeController = new YoutubeController();
        $this->videoController = new VideoController();
    }

    /**
     * Add Admin Page
     */

    public function createAdminPage()
    {




        $returnArray = ['step' => 'default'];

        $adminPage = tr_page('Video Importer', 'view', 'Video Importer' , ['capability' => 'administrator']);

        $request = tr_request(); //Get Request

        $youtubeLinkSubmitted = $request->getInput('checker'); // Get Request
        $isVideoSelector = $request->getInput('isVideoSelector'); // Get Request

        if($youtubeLinkSubmitted){

            $youtubeLink = $request->getInput('youtubeLink');

            if (!$youtubeLink){
                $returnArray = ['step' => 'youtubelink' , 'error' => 1 , 'message' => 'Invalid youtube username'];
            } else {
                
                $data = $this->youtubeController->fetchData($youtubeLink);

                if($data){
                    $returnArray = ['step' => 'choose' , "data" =>  $data];
                } else {
                    $returnArray = ['step' => 'youtubelink' , 'error' => 1 , 'message' => 'No result Found'];
                }
                
            }
            
        } else if ($isVideoSelector){
            // Check and insert videos
            $youtubeIds = $request->getInput('yt_id');

            if($youtubeIds ){
                $videosImported = $this->youtubeController->getVideoChoosedList($youtubeIds); // Return video detail list from API

                // Data will be saved here

                foreach ($videosImported as $video){
                    $this->videoController->save($video);
                }
                
            } 
        } 

        $view = ViewTrait::viewRender('my.view' , $returnArray);
        $adminPage->setView($view);
    }


    /**
     * Create Post Type
     */
    public function createPostType()
    {
        // Create Video post Type and set only for Admin
        $easyVideo = tr_post_type('Video')
                    ->setAdminOnly()
                    ->setEditorForm(function(){
                        $form = tr_form()->setGroup('details');
                        echo $form->image('Video Picture');
                        echo $form->text('Video Id');
                        echo $form->text('published At');
                        echo $form->text('channel Name');
                    });

        // Call Page Creator Action 

        $this->createAdminPage();
       
    }
}

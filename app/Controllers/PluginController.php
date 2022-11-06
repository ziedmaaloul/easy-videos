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


    /**
     * Constructor
     */
    public function __construct(){
        $this->youtubeController = new YoutubeController();
        $this->videoController = new VideoController();
    }

    /**
     * Add Admin Page
     * @return void
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

                if($data["success"] && $data['data']){
                    $returnArray = ['step' => 'choose' , "data" =>  $data['data']];
                } else if($data["success"] && !$data['data']) {
                    $returnArray = ['step' => 'youtubelink' , 'error' => 1 , 'message' => 'No result Found'];
                } else {
                    $returnArray = ['step' => 'youtubelink' , 'error' => 1 , 'message' => $data['message']];
                }
                
            }
            
        } else if ($isVideoSelector){
            // Check and insert videos
            $youtubeIds = $request->getInput('yt_id');

            if($youtubeIds ){
                $videosImported = $this->youtubeController->getVideoChoosedList($youtubeIds); // Return video detail list from API

                // Save Video to database

                foreach ($videosImported as $video){
                    $this->videoController->save($video);
                }

                $returnArray = ['step' => 'default' , "success" =>  1 , "message" => "Video Imported"];
                
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
                    ->setIcon('dashicons-format-video')
                    ->setId('video')
                    ->setSlug('video')
                    ->setArchivePostsPerPage(-1)
                    ->setArgument( 'public', true)
                    ->setEditorForm(function(){
                        $form = tr_form()->setGroup('details');
                        echo $form->image('Video Picture');
                        echo $form->text('Video Id');
                        echo $form->text('published At');
                        echo $form->text('channel Name');
                    });
                    
                    

        // Call Page Creator Action 


        // Start Force User to Add his API KEY 
        
        global $pagenow;
        $admin_pages = [ 'index.php', 'plugins.php' , 'edit.php' ];
        if ( in_array( $pagenow, $admin_pages )  && !typerocket_env('GOOGLE_API_KEY')) {
                echo '
                <div class="notice notice-error">
                    <p>To use Import Video From Youtube using Easy Videos Plugins ,
                     Please Add This Line To your wp_settings.php
                     </p><br>'."
                     define( 'GOOGLE_API_KEY', 'xxxxxxxxxxxx' );".'
                    <br> Be sure to replace xxxxxxxxxxxx by your GOOGLE API KEY
                </div>';

                return;
        }
        
        $this->createAdminPage();
       
    }
}

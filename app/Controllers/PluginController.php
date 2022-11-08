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
     * Save Settings Action 
     * @param Request $request
     * @return array
     */
    public function saveSettings($request)
    {
        $responseArray = [];
        $errorMessage = [];
        $isVideoApiKey = $request->getInput('isVideoApiKey'); // Get Request
        $googleApiKey = $request->getInput('googleApiKey'); // Get Request
        $resultPerPage = $request->getInput('resultPerPage'); // Get Request

        if($isVideoApiKey){

            if(!$googleApiKey){
                $errorMessage[] = 'Invalid Api Key';
                $responseArray = ['error' => 1];
            }

            if(!$resultPerPage){
                $errorMessage[] = 'Invalid Result per page Value';
                $responseArray = ['error' => 1];
            }
        
            if(!ctype_digit($resultPerPage)){
                $errorMessage[] = 'Result per page Value Must be of type Digital';
                $responseArray = ['error' => 1];
            }
        
            if ($resultPerPage <= 0){
                $errorMessage[] = 'Result per page Value Must be greater than 0';
                $responseArray = ['error' => 1];
            }

            if(!isset($responseArray['error'])){

                // If all tests passed , Update new settings values
                $this->videoController->updateSettingsKeyValue('easy_video_google_api_key',$googleApiKey);
                $this->videoController->updateSettingsKeyValue('easy_video_google_result_number',$resultPerPage);
                $responseArray = ['success' => 1];
            }

            $responseArray['messages'] = $errorMessage;
        }

        return $responseArray;
    }


    /**
     * Import Video Processing 
     * @param Request $request
     * @return array
     */

    public function importVideoProcessing($request)
    {

        $returnArray = ['step' => 'default'];

        $youtubeLinkSubmitted = $request->getInput('checker'); // Get Request
        $isVideoSelector = $request->getInput('isVideoSelector'); // Get Request

        if($youtubeLinkSubmitted){
    
            $youtubeLink = $request->getInput('youtubeLink');

            if (!$youtubeLink){
                $returnArray = ['step' => 'youtubelink' , 'error' => 1 , 'message' => 'Invalid youtube username'];
            } else {
                
                $data = $this->youtubeController->fetchData($youtubeLink);

                if($data["success"] && $data['data']){
                    $returnArray = ['step' => 'choose' , "data" =>  $data['data'] , 'channelId' => $data['channelId'] , 'hasNext' => $data['hasNext'] , "nextPageToken" => $data["nextPageToken"]];
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

        return $returnArray;
    }

    
    /**
     * Add Admin Page
     * @return void
     */

    public function createAdminPage()
    {
        $request = tr_request(); //Get Request

       
        $settingsArray = $this->saveSettings($request);
        $isAPIValid = $this->videoController->checkAndPrepareAPI();
       
        if(!$isAPIValid){
            $settingsArray['validApi'] = false;
            $viewConfig = ViewTrait::viewRender('my.api_config' , $settingsArray);
            $addVideoConfigPage = tr_page('Video API Config' , 'apiconfig', 'Video API Config' ,  ['capability' => 'administrator']);
            $addVideoConfigPage->setView($viewConfig);
        } else {
            $adminPage = tr_page('Video Importer', 'view', 'Video Importer' , ['capability' => 'administrator']);
            // Check if ll test passed to Get requests and import Video process
            $returnArray = $this->importVideoProcessing($request);
    
            $view = ViewTrait::viewRender('my.view' , $returnArray);
            $adminPage->setView($view);
            $isAPIValid['validApi'] = true;
            $settingsArray = array_merge($settingsArray , $isAPIValid);
            $addVideoConfigPage = tr_page('API Config' , 'apiconfig', 'API Config' ,  ['capability' => 'administrator']);
            $viewConfig = ViewTrait::viewRender('my.api_config' , $settingsArray);
            $addVideoConfigPage->setView($viewConfig);
            $adminPage->addPage($addVideoConfigPage);
        }
        
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
        $admin_pages = [ 'index.php', 'plugins.php' , 'edit.php'];
        if ( in_array( $pagenow, $admin_pages )  && !typerocket_env('GOOGLE_API_KEY')) {
                $isAPIValid = $this->videoController->checkAndPrepareAPI();
                if(!$isAPIValid){
                    echo '
                    <div class="notice notice-error">
                        <p>To use Import Video From Youtube using Easy Videos Plugins ,
                         Please Add Your Google API Key and Result per page.
                         <a href="/wp-admin/admin.php?page=video_api_config_apiconfig">Go To</a>
                    </div>';
                }
               
        }
        
        $this->createAdminPage();
       
    }
}

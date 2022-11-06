<?php

namespace App\Controllers;
use \Google\Client;
use \Google\Service\Youtube;
class YoutubeController
{
    protected $client = null;
    protected $service = null;

    /**
     * Constructor
     */

    public function __construct(){
        $this->client = new Client();
        $this->client->setApplicationName("Youtube_Importer");
        $this->client->setDeveloperKey(typerocket_env('GOOGLE_API_KEY'));
        $this->service = new Youtube($this->client);
    }

    public function parseChannelId(string $url) {

        $html = file_get_contents($url);
        preg_match("'<meta itemprop=\"channelId\" content=\"(.*?)\"'si", $html, $match);
        if($match && $match[1]){
            return ["success" => true , "id" => $match[1]];
        }

        return ["success" => false , "message" => "{$url} is not a valid YouTube channel URL"];
    }

    /**
     * Constrcut Data from search list to array
     * @param  Google\Service\YouTube\VideoListResponse $searchResult
     * @return array
     */

    private function constructData($searchResult , $searchList = 0){

        if(!$searchResult){
            return [];
        }

        $resultList = [];

        $kindOperator = null;


        foreach ($searchResult->getItems() as $item) {
            $itemId = $item->id; // Get Item ID
            $itemSnippet = $item->snippet; // Get Item Snippet

            if ($searchList) {
                $kindOperator = $item->kind;
            } else {
                $kindOperator = $itemId->kind;
            }

    
            if($itemId && $kindOperator == 'youtube#video'){ // Be sure that this result is Video
                $resultList[] = ['videoId' => $searchList ? $itemId : $itemId->videoId , 'description' => $itemSnippet->description , 'publishedAt' => $itemSnippet->publishedAt,
                                'title' => $itemSnippet->title , 'thumbnails' => $itemSnippet->thumbnails->medium->url
                ];
            }
        }

        return $resultList;
    }

    /**
     * Fetch Data Function return Result List
     * @param string $channelName
     * @return array
     */
   public function fetchData($channel)
   {
        
        $channelArray = $this->parseChannelId($channel);
        
        // Check if Link is a valid url
        if(!$channelArray['success']){
            return $channelArray;
        }


        $optParams = [
            'part' => 'snippet',
            'maxResults' => 1000,
            'channelId'=> $channelArray['id']
        ];

        $searchResult =  $this->service->search->listSearch('', $optParams);


        return ['success' => true , 'data' => $this->constructData($searchResult)];
    }

    /**
     * Return Videos details array from Ids array
     * @param array $youtubeIds
     * @return array
     */
    public function getVideoChoosedList(array $youtubeIds)
    {
        if (!$youtubeIds){
            return [];
        }

        $query = '';
        $optParams = [
            'part' => 'snippet',
            'id' => implode(',',$youtubeIds)
            //   'channelId'=> $query
        ];

        $searchResult =  $this->service->videos->listVideos('', $optParams);

        return $this->constructData($searchResult  , 1);
    }
}

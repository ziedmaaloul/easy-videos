<?php

namespace App\Controllers;
use \Google\Client;
use \Google\Service\Youtube;
class YoutubeController
{
    protected $client = null;
    protected $service = null;
    protected $type = 'video';
    protected $maxResult = 15;

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
     * Get Data From Youtube API
     * pageToken is a pagination param , for first value is CAoQAA
     * @param string $channelId
     * @param string  $pageToken
     * @return array
     */
    public function getDataFromYoutube($channelId , $pageToken = 'CAoQAA'){

        $optParams = [
            'part' => 'snippet',
            'type' => $this->type,
            'pageToken' =>  $pageToken,
            'maxResults' => $this->maxResult,
            'channelId'=> $channelId
        ];

        // Get response from Youtube API
        $searchResult =  $this->service->search->listSearch('', $optParams);

        // Check if video list has next pagination
        $hasNext = false;

        $pageInfo = isset($searchResult['pageInfo']) ? $searchResult['pageInfo'] : null;
        $nextPageToken = isset($searchResult['nextPageToken']) ? $searchResult['nextPageToken'] : null;
        if($pageInfo && $nextPageToken) {
            $hasNext = true;
        }

        return ['success' => true , 'data' => $this->constructData($searchResult) , 'channelId' => $channelId , 'hasNext' => $hasNext , 'nextPageToken' => $nextPageToken];
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


        return $this->getDataFromYoutube($channelArray['id'] , 'CAoQAA');
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

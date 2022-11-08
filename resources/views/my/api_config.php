<?php

function displayMessage($message , $type = 'danger'){
    echo '<div class="alert alert-'.$type.'" role="alert">
            '.$message.'
        </div>';
}


if(!$validApi){
    displayMessage('You must enter your API Key and Results number to import videos');
}

if(isset($error)){
    $listOfMessages = '';
    foreach ($messages as $message){
        $listOfMessages.= '- '.$message.'<br>';
    }

    displayMessage($listOfMessages);
}

if(isset($success)){
    displayMessage('Your API Settings are now Saved , You can start Importing Videos ...' , 'success');
}
?>

<section>
        <form method="POST">
            <input type="hidden" value="1" name="isVideoApiKey"/>
            <div class="mb-3">
                    <label class="form-label">GoogleApiKey</label>
                    <input type="text"value="<?= isset($easy_video_google_api_key) ? $easy_video_google_api_key : 'xxxXxxxXXxxXXXxXXXxXxxxxx' ; ?>" name="googleApiKey"  class="form-control" placeholder="Google Api Key">
            </div>
            <div class="mb-3">
                    <label  class="form-label">Result Number per page</label>
                    <input type="number" value="<?= isset($easy_video_google_result_number) ? $easy_video_google_result_number : 15; ?>" name="resultPerPage"  class="form-control" placeholder="Result Number per page">
            </div>
            <button type="submit" class="btn btn-primary"> Save Settings</button>
        </form>
</section>

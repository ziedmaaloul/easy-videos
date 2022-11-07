<?php

function displayMessage($message , $type = 'danger'){
    echo '<div class="alert alert-'.$type.'" role="alert">
            '.$message.'
        </div>';
}


function displayYoutubeLinkForm(){
    
    echo '<section>
                <form method="POST">
                    <input type="hidden" value="1" name="checker"/>
                    <div class="mb-3">
                            <label for="youtubeChannel" class="form-label">Youtube Channel</label>
                            <input type="text"value="https://www.youtube.com/c/LinusTechTips/videos" name="youtubeLink"  class="form-control" id="youtubeChannel" placeholder="Youtube Channel">
                    </div>
                    <button type="submit" class="btn btn-primary"> Fetch Videos ...</button>
                </form>
            </section>';
}

if($step == 'youtubelink' || $step == 'default'){

    if(isset($error)){
        displayMessage($message);
    }

    if(isset($success)){
        displayMessage($message , 'success');
    }

    displayYoutubeLinkForm();
}

if($step =='choose'){  ?>
        <section>
            <form method="POST">
            <input type="hidden" value="1" name="isVideoSelector"/>

            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Title</th>
                    <th scope="col">VideoId</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include EASY_VIDEOS_RESOURCES_PATH."/partials/videoMultiple.php" ?>
                    <?php include EASY_VIDEOS_RESOURCES_PATH."/partials/loadMoreButton.php" ?>
                </tbody>
                </table>
                
                <button type="submit" class="btn btn-primary btn-center"> Import ...</button>
            </form>
        </section>
<?php } ?>

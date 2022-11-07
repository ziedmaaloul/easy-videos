<?php 
    if($hasNext)
        { 
            ?> 
            <tr id="loadMoreContainer" class="video-element">
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary btn-center" id="loadMore" data-token="<?= $nextPageToken ;?>" data-channel-id="<?= $channelId; ?>">
                        <span style="display:none" id="loadMoreIcon"><img src="<?=  site_url().'/'.EASY_VIDEOS_URL.'/resources/assets/svgs/spinner.svg'; ?>"width="51px" /></span>Load More
                    </button>
                </td>
                </td>
            </tr>
            <?php
 
        }
?>
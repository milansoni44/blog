<div id="site_content">
    <div id="content">
    <!-- insert the page content here -->
        <?php if(!isset($post))
            {echo "This page was accessed incorrectly";}
            else //display the post
            {?>
                <h2><?=$post['post_title']?></h2>
                <p><?=$post['post']?></p>
                
                <hr>
                <div class="like_dislike_stat"><a href="#" class="like_post" data-post_id="<?= $post['post_id'] ?>"><i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i></a>&nbsp;<div class="like_count" style="display: inline-block;"><?= $post['likes'] ?></div> &nbsp;&nbsp;&nbsp;<a href="#" class="dislike_post" data-post_id="<?= $post['post_id'] ?>"><i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i></a>&nbsp; <div class="dislike_count" style="display: inline-block;"><?= $post['dislikes'] ?></div></div>  
            <?php
            }?>
    </div>
</div>
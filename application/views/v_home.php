<div id="site_content">
    <div id="content">
        <?php if($this->session->userdata('user_id'))
        { ?>
        <h2><a style="color: green" href="<?=  base_url()?>index.php/blog/new_post/"><span class="glyphicon glyphicon-pencil"></span> Create a new post</a></h2>
        <?php } ?>
    <!-- insert the page content here -->
    <?php foreach($posts as $post)
    { ?>
    <h2><a style="color:red;" href="<?=  base_url()?>index.php/blog/post/<?=$post['post_id']?>"><?=$post['post_title'];?></a></h2>
        <?php if($this->session->userdata('user_id') && $post['user_id'] == $this->session->userdata('user_id') )
        { ?>
        <p>
            <a href="<?=  base_url()?>index.php/blog/editpost/<?=$post['post_id']?>"><span class="glyphicon glyphicon-edit" title="Edit post"></span></a> | 
            <a href="<?=  base_url()?>index.php/blog/deletepost/<?=$post['post_id']?>"><span style="color:#f77;" class="glyphicon glyphicon-remove-circle" title="Delete post"></span></a>
        </p>
       <?php }?>
        <p><?=  substr(strip_tags($post['post']), 0, 200).'...';?></p>
        
        <div class="like_dislike_stat"><a href="#" class="like_post" data-post_id="<?= $post['post_id'] ?>"><i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i></a>&nbsp;<div class="like_count" style="display: inline-block;"><?= $post['likes'] ?></div> &nbsp;&nbsp;&nbsp;<a href="#" class="dislike_post" data-post_id="<?= $post['post_id'] ?>"><i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i></a>&nbsp; <div class="dislike_count" style="display: inline-block;"><?= $post['dislikes'] ?></div></div>
        
    <?php
    }?>
    <?=$pages?>
    </div>
</div>
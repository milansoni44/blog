    <div id="footer">
      <p>Practical</p>
    </div>
  </div>
  <script src="<?=  base_url()?>public/js/jquery-2.1.1.min.js"></script>
  <script src="<?=  base_url()?>public/js/bootstrap.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function(){
        $('.like_post').on('click', function(e){
          e.preventDefault();
          
            var $this = $(this)
            var $postId = $this.attr('data-post_id');

            if($postId) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/blog/like",
                    method: "POST",
                    async: false,
                    cache: false,
                    dataType: 'json',
                    data: {post_id: $postId, like_flag: 'LIKE'},
                    success: function(response) {
                        console.log(response);
                        if(response.status == false && response.code == 400) {
                          alert("You are not logged in. Please login.");
                            window.location.href = "<?php echo base_url(); ?>index.php/users/login";
                            return;
                        } else if(response.status == false && response.code == 403) {
                            alert("You cannot like twice.").
                            return;
                        } else if(response.status == false && response.code == 500){
                          alert("Some problem occured. Please try again later.");
                          return;
                        } else {
                          alert('Likes successfully.');
                            $this.closest('.like_dislike_stat').find('.like_count').html(response.data.likes);
                            $this.closest('.like_dislike_stat').find('.dislike_count').html(response.data.dislikes);
                        }
                    }
                })
            }
            return;
        });

        $('.dislike_post').on('click', function(e){
          e.preventDefault();
          
            var $this = $(this)
            var $postId = $this.attr('data-post_id');

            if($postId) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/blog/dislike",
                    method: "POST",
                    async: false,
                    cache: false,
                    dataType: 'json',
                    data: {post_id: $postId, like_flag: 'DISLIKE'},
                    success: function(response) {
                        console.log(response);
                        if(response.status == false && response.code == 400) {
                          alert("You are not logged in. Please login.");
                            window.location.href = "<?php echo base_url(); ?>index.php/users/login";
                            return;
                        } else if(response.status == false && response.code == 403) {
                            alert("You cannot dislike twice.").
                            return;
                        } else if(response.status == false && response.code == 500){
                          alert("Some problem occured. Please try again later.");
                          return;
                        } else {
                          alert('Dislikes successfully.');
                          $this.closest('.like_dislike_stat').find('.like_count').html(response.data.likes);
                          $this.closest('.like_dislike_stat').find('.dislike_count').html(response.data.dislikes);
                        }
                    }
                })
            }
            return;
        })
      });
  </script>
</body>
</html>


<?php
class M_db extends CI_Model
{
    function get_posts($number = 10, $start = 0)
    {
        $sql = $this->db->query("SELECT
                                    posts.post_id,
                                    posts.post_title,
                                    posts.post,
                                    posts.active,
                                    posts.date_added,
                                    posts.user_id,
                                    IFNULL(tlikes.total_likes, 0) AS likes,
                                    IFNULL(tdislikes.total_dislikes, 0) AS dislikes
                                FROM posts
                                LEFT JOIN (
                                    SELECT
                                        COUNT(*) AS total_likes,
                                        post_id
                                    FROM likes
                                    WHERE likes.like_flag = 'LIKE'
                                    GROUP BY post_id
                                ) AS tlikes ON tlikes.post_id = posts.post_id
                                LEFT JOIN (
                                    SELECT
                                        COUNT(*) AS total_dislikes,
                                        post_id
                                    FROM likes
                                    WHERE likes.like_flag = 'DISLIKE'
                                    GROUP BY post_id
                                ) AS tdislikes ON tdislikes.post_id = posts.post_id
                                WHERE posts.active = 1
                                ORDER BY posts.date_added DESC
                                LIMIT $start, $number
                ");
        // echo $this->db->last_query();die;
        return $sql->result_array();
    }

    function get_post_count()
    {
        $this->db->select()->from('posts')->where('active',1);
        $query = $this->db->get();
        return $query->num_rows;
    }

    function get_post($post_id)
    {
        
        $sql = $this->db->query("SELECT
                                    posts.post_id,
                                    posts.post_title,
                                    posts.post,
                                    posts.active,
                                    posts.date_added,
                                    IFNULL(tlikes.total_likes, 0) AS likes,
                                    IFNULL(tdislikes.total_dislikes, 0) AS dislikes
                                FROM posts
                                LEFT JOIN (
                                    SELECT
                                        COUNT(*) AS total_likes,
                                        post_id
                                    FROM likes
                                    WHERE likes.like_flag = 'LIKE'
                                    GROUP BY post_id
                                ) AS tlikes ON tlikes.post_id = posts.post_id
                                LEFT JOIN (
                                    SELECT
                                        COUNT(*) AS total_dislikes,
                                        post_id
                                    FROM likes
                                    WHERE likes.like_flag = 'DISLIKE'
                                    GROUP BY post_id
                                ) AS tdislikes ON tdislikes.post_id = posts.post_id
                                WHERE posts.active = 1
                                AND posts.post_id = '{$post_id}'
                                ORDER BY posts.date_added DESC 
                                ");
        return $sql->first_row('array');
    }
    function insert_post($data)
    {
        $this->db->insert('posts',$data);
        return $this->db->insert_id();
    }
    
    function update_post($post_id, $data)
    {
        $this->db->where('post_id',$post_id);
        $this->db->update('posts',$data);
    }
    
    function delete_post($post_id)
    {
        $this->db->where('post_id',$post_id);
        $this->db->delete('posts');
    }

    public function like_post($data = []) {
        if(!empty($data)) {
            $this->db->delete("likes", ['post_id'=>$data['post_id'], 'user_id'=>$data['user_id']]);
            
            $this->db->insert('likes', $data);
            return $this->db->insert_id();
        }
    }

    public function check_duplicate_likes($data = []){
        $total_likes = $this->db->query("SELECT
                    COUNT(*) AS total_likes
                FROM likes
                WHERE likes.user_id = '{$data['user_id']}'
                AND likes.post_id = '{$data['post_id']}' 
                AND likes.like_flag = '{$data['like_flag']}'
                ")->row_array()['total_likes'];
        return $total_likes;
    }
}

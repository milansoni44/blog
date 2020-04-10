<?php

class Blog extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_db');
    }

    function index($start = 0)//index page
    {
        $data['posts'] = $this->m_db->get_posts(5, $start);
        // echo "<pre>"; print_r($data['posts']);die;
        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/blog/index/';//url to set pagination
        $config['total_rows'] = $this->m_db->get_post_count();
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        $this->load->view('header', $class_name);
        $this->load->view('v_home', $data);
        $this->load->view('footer');
    }

    function post($post_id)//single post page
    {
        $this->load->model('m_comment');
        // $data['comments'] = $this->m_comment->get_comment($post_id);
        $data['post'] = $this->m_db->get_post($post_id);
        // echo "<pre>"; print_r($data['post']);die;
        $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
        $this->load->view('header', $class_name);
        $this->load->view('v_single_post', $data);
        $this->load->view('footer');
    }

    function new_post()//Creating new post page
    {
        //when the user is not an admin and author
        if (!$this->session->userdata('user_id'))//when the user is not an admin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        if ($this->input->post()) {
            $data = array('post_title' => $this->input->post('post_title'), 'post' => $this->input->post('post'), 'active' => 1,'user_id'=>$this->session->userdata('user_id'));
            $this->m_db->insert_post($data);
            redirect(base_url() . 'index.php/blog/');
        } else {

            $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
            $this->load->view('header', $class_name);
            $this->load->view('v_new_post');
            $this->load->view('footer');
        }
    }

    function editpost($post_id)//Edit post page
    {
        if (!$this->session->userdata('user_id'))//when the user is not an admin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        $data['success'] = 0;

        if ($this->input->post()) {
            $data = array('post_title' => $this->input->post('post_title'), 'post' => $this->input->post('post'), 'active' => 1);
            $this->m_db->update_post($post_id, $data);
            $data['success'] = 1;
        }
        $data['post'] = $this->m_db->get_post($post_id);

        $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
        $this->load->view('header', $class_name);
        $this->load->view('v_edit_post', $data);
        $this->load->view('footer');
    }

    function deletepost($post_id)//delete post page
    {
        if (!$this->session->userdata('user_id'))//when the user is not an andmin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        $this->m_db->delete_post($post_id);
        redirect(base_url() . 'index.php/blog/');
    }

    public function like(){
        $user_id = $this->session->userdata('user_id');

        if(isset($user_id)) {
            // echo "<pre>"; print_r($this->input->post());die;
            $post_id = $this->input->post("post_id");
            $data = [
                'post_id'=>$post_id,
                'like_flag'=>$this->input->post("like_flag"),
                'user_id'=>$user_id
            ];
            if($this->m_db->check_duplicate_likes($data)) {
                $response = [
                    'status'=>false,
                    'message'=>"You cannot like twice.",
                    'data'=>[],
                    'code'=>403
                ];
                echo json_encode($response);die;
            }
            if($like_id = $this->m_db->like_post($data)) {
                $response = [
                    'status'=>true,
                    'message'=>"Like successfull.",
                    'data'=>$this->m_db->get_post($post_id),
                    'code'=>200
                ];
            } else {
                $response = [
                    'status'=>false,
                    'message'=>"Some problem occured.",
                    'data'=>[],
                    'code'=>500
                ];
            }
        } else {
            $response = [
                "status"=> false,
                "message"=>"User not logged in",
                "data"=>[],
                'code'=>400
            ];
        }
        echo json_encode($response);die;
    }

    public function dislike(){
        $user_id = $this->session->userdata('user_id');

        if(isset($user_id)) {
            // echo "<pre>"; print_r($this->input->post());die;
            $post_id = $this->input->post("post_id");
            $data = [
                'post_id'=>$post_id,
                'like_flag'=>$this->input->post("like_flag"),
                'user_id'=>$user_id
            ];
            if($this->m_db->check_duplicate_likes($data)) {
                $response = [
                    'status'=>false,
                    'message'=>"You cannot dislike twice.",
                    'data'=>[],
                    'code'=>403
                ];
                echo json_encode($response);die;
            }
            if($like_id = $this->m_db->like_post($data)) {
                $response = [
                    'status'=>true,
                    'message'=>"Dislike successfull.",
                    'data'=>$this->m_db->get_post($post_id),
                    'code'=>200
                ];
            } else {
                $response = [
                    'status'=>false,
                    'message'=>"Some problem occured.",
                    'data'=>[],
                    'code'=>500
                ];
            }
        } else {
            $response = [
                "status"=> false,
                "message"=>"User not logged in",
                "data"=>[],
                'code'=>400
            ];
        }
        echo json_encode($response);die;
    }
}
<?php

class Users extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    
    public function register()
    {
        if ( empty($_POST) )
            redirect('/');

        $delete = $this->input->post('delete');

        if ($delete == 'true')
        {
            $this->user_model->delete_last();
        }

        $this->form_validation->set_rules('register_name','Name','required');
        $this->form_validation->set_rules('register_email','Email','required|valid_email|callback_check_email_exists');
        $this->form_validation->set_rules('register_password','Password','required|min_length[6]');
        $this->form_validation->set_rules('register_password_confirm','Confirm Password','required|matches[register_password]');

        if ( $this->form_validation->run() === false ){
            $arr = array(
                'error' => true,
                'register_name' => strip_tags(form_error('register_name')),
                'register_email' => strip_tags(form_error('register_email')),
                'register_password' => strip_tags(form_error('register_password')),
                'register_password_confirm' => strip_tags(form_error('register_password_confirm')),
            );
            echo json_encode($arr);
        }
        else{
            $arr = array(
                'error' => false
            );
            $enc_password = password_hash( $this->input->post('register_password') , PASSWORD_DEFAULT );
            $id = $this->user_model->register($enc_password);
            $arr['register_success'] = "You have registered succesfully !";
            $arr['id'] = $id;
        
            if ( $this->input->post('auto_login') === 'true' ){
                $arr['auto_login'] = true;
                $user = $this->user_model->login($this->input->post('register_email') , $this->input->post('register_password') );
                if ( is_array($user) ){
                $user_data = array(
                    'user_id'    => $user['user_id'],
                    'user_name'  => $user['user_name'],
                    'user_email' => $user['user_email'],
                    'logged_in'  => true
                    );
                    $this->session->set_userdata($user_data);
                    $arr['register_success'] = "You have registered succesfully ! Loggin in...";
                }
            }

            echo json_encode($arr);
        }
    }

    public function login(){
        if ( empty($_POST) )
            redirect('/');

        $this->form_validation->set_rules('login_email','Email','required|valid_email');
        $this->form_validation->set_rules('login_password','Password','required');

        if ( $this->form_validation->run() === false ){
            $arr = array(
                'error' => true,
                'login_email' => strip_tags(form_error('login_email')),
                'login_password' => strip_tags(form_error('login_password')),
            );
            echo json_encode($arr);
        }
        else{
            $arr = array(
                'error' => false
            );
            $user = $this->user_model->login($this->input->post('login_email') , $this->input->post('login_password') );
            if ( is_array($user) ){
                $user_data = array(
                    'user_id'    => $user['user_id'],
                    'user_name'  => $user['user_name'],
                    'user_email' => $user['user_email'],
                    'logged_in'  => true
                );
                $this->session->set_userdata($user_data);
                $arr['login_success'] = "You have logged in successfully";
            }
            else{
                $arr['login_failed'] = "Email or Password incorrect";
            }
            echo json_encode($arr);
        }
    }

    public function reset_password(){
        if ( empty($_POST) )
            redirect('/');
            
        $this->form_validation->set_rules('reset_email','Email','required|valid_email');

        if ( $this->form_validation->run() === false ){
            $arr = array(
                'error' => true,
                'reset_email' => strip_tags(form_error('reset_email'))
            );
            echo json_encode($arr);
        }
        else{
            $arr = array(
                'error' => false
            );
            if ($this->user_model->check_email_exists($this->input->post('reset_email')) ){
                $arr['recover_failed'] = "This email doesn't exist. Please register first";
            }
            else{
                $this->load->config('email');
                $this->load->library('email');

                $token = bin2hex( random_bytes(20) );
               
                $this->user_model->store_token($this->input->post('reset_email'),$token);
                
                $this->email->from( 'onlinesurveyfinalproject@gmail.com', 'OnlineSurvey' );
                
                $this->email->to( $this->input->post('reset_email') );

                $this->email->subject('Recover your password : OnlineSurvey');
                $link = 'http://onlinesurvey.local/recover-password/' . $token;
                if ( file_exists( 'assets/email/email_recover.html') ){
                    $this->email->attach( base_url('assets/img/circle-cropped.png') , 'inline');
                    $cid = $this->email->attachment_cid(base_url('assets/img/circle-cropped.png'));
                    $email = file_get_contents( base_url('assets/email/email_recover.html') );
                    $email = str_replace('cid' , 'cid:'.$cid , $email);
                    $email = str_replace('http://onlinesurvey.local' , $link , $email);
                    $this->email->message($email);
                    
                    if ($this->email->send()) {
                        $arr['recover_success'] = "A link to reset your password has been sent";
                    } else {
                        $arr['recover_success'] = "There has been a problem. Please try again";
                    }
                }
                else{
                    $arr['recover_failed'] = "File not found";
                }
                
            }
            echo json_encode($arr);
        }
    }

    public function reset_password_confirm_view($token){
        $data['token'] = $token;

        $this->session->set_userdata('page','/recover-password'.'/'.$token);
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header');
            $this->load->view($this->input->cookie('lang') . '/app/recover_password' , $data );
            $this->load->view('templates/footer');
        }
        else{
            $this->load->view('templates/header' );
            $this->load->view('eng/app/recover_password' , $data);
            $this->load->view('templates/footer');
        }
    }

    public function reset_password_confirm($token){
        if ( empty($_POST) )
            redirect('/');

        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('password_confirm','Confirm Password','required|matches[password]');

        if ( $this->form_validation->run() === true ){ 
            if (! $this->user_model->verify_token($this->input->post('email') , $token) ){
                $this->session->set_flashdata("error" , "Your email might be invalid or Token has expired");
            }
            else{
                $new_password = password_hash($this->input->post('password') , PASSWORD_DEFAULT);
                if (! $this->user_model->update_password($this->input->post('email'),$new_password) ){
                    $this->session->set_flashdata("success-error" ,"Database Error");
                }
                else{
                    $this->session->set_flashdata("success" ,"Your password has been updated successfully !");
                }
            }
        }
        $data['token'] = $token;

        $this->session->set_userdata('page','/recover-password'.'/'.$token);
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header');
            $this->load->view($this->input->cookie('lang') . '/app/recover_password' , $data );
            $this->load->view('templates/footer');
        }
        else{
            $this->load->view('templates/header' );
            $this->load->view('eng/app/recover_password' , $data);
            $this->load->view('templates/footer');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('logged_in');
        redirect('/home');
    }

    public function settings()
    {
        $this->form_validation->set_rules('name','Name','required');
        if ( $this->input->post('email') !== $this->session->userdata('user_email') )
            $this->form_validation->set_rules('email','Email','required|valid_email|callback_check_email_exists');

        if ( empty($this->input->post('old_password')) && empty($this->input->post('new_password') ) && empty($this->input->post('new_password_confirm')) )
        {
            if ( $this->form_validation->run() === true )
            {
                $this->user_model->update_user(  $this->session->userdata('user_id') , $this->input->post('name') , $this->input->post('email') );
                $this->session->set_flashdata('username_update' , 'Your username and email have been updated successfully');
                $this->session->set_userdata('user_name' , $this->input->post('name')); 
                $this->session->set_userdata('user_email' , $this->input->post('email'));
                redirect('/dashboard');
            }
       
        }
        else
        {
            $this->form_validation->set_rules('old_password','Old Password','required|callback_check_password_real');
            $this->form_validation->set_rules('new_password','New Password','required|min_length[6]');
            $this->form_validation->set_rules('new_password_confirm','Confirm Password','required|matches[new_password]');
            if ( $this->form_validation->run() === true )
            {
                $this->user_model->update_user(  $this->session->userdata('user_id') , $this->input->post('name') , $this->input->post('email') );
                $this->user_model->update_password(  $this->input->post('email') , password_hash($this->input->post('new_password') , PASSWORD_DEFAULT)  );
                $this->session->set_flashdata('username_update' , 'Your username, email and Password have been updated successfully');
                $this->session->set_userdata('user_name' , $this->input->post('name')); 
                $this->session->set_userdata('user_email' , $this->input->post('email'));
                redirect('/dashboard');
            }

        }
        $data['user'] = $this->user_model->get_user( $this->session->userdata('user_id') );
        $data['user_img'] = $this->user_model->get_user_img($this->session->userdata('user_id'));

        $this->session->set_userdata('page','/users/settings');
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' ,  array('style' => 'settings'));
            $this->load->view($this->input->cookie('lang') . '/app/profile' , $data );
            $this->load->view('templates/footer' , array('script' => 'settings'));
        }
        else{
            $this->load->view('templates/header' , array('style' => 'settings'));
            $this->load->view('eng/app/profile' , $data);
            $this->load->view('templates/footer' , array('script' => 'settings'));
        }
    }

    public function check_email_exists($email=FALSE)
    {
        if ( empty($_POST) )
            redirect('/');

        $this->form_validation->set_message('check_email_exists','This email is taken. Please Choose another');
        if ( $this->user_model->check_email_exists($email) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function check_password_real($password=FALSE)
    {
        if ( empty($_POST) )
            redirect('/');
        $this->form_validation->set_message('check_password_real','Wrong Old Password.');
        if ( $this->user_model->check_password_real($this->session->userdata('user_id') , $password) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function upload_image()
    {       
         if ( isset($_FILES['userfile']['name']) ){
             $config['upload_path']          = './assets/img/uploads/users';
             $config['allowed_types']        = 'jpg|gif|png|jpeg';
             $config['max_size']             = 2048;
             $config['max_width']            = 1000;
             $config['max_height']           = 1000;
 
             $this->load->library('upload', $config);
 
             if ( ! $this->upload->do_upload('userfile'))
             {
                $data = array(
                    'error' => true,
                    'msg' => $this->upload->display_errors(),
                    'files' => $_FILES
                );
                echo json_encode($data);
             }
             else
             {
                 $data = array('upload_data' => $this->upload->data());
                 $this->user_model->insert_img( $this->session->userdata('user_id') , $data['upload_data']['file_name'] );
                 echo json_encode($data['upload_data']);
             }
 
         }
         else
             echo json_encode(array('error'=>true));
 
    }

}
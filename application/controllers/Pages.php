<?php

class Pages extends CI_Controller{
    public function view($page='home'){
        if ( !file_exists( APPPATH.'views/eng/pages/'.$page.'.php' ) ){
            show_404();
        }
        
        if ($this->session->userdata('logged_in'))
            redirect('/dashboard');

        $data['url'] = 'http://onlinesurvey.local';

        if (strtolower($page) == 'contact'){
            $style['style'] = 'about';
            $script['script'] = 'about';
        }
        else{ 
            $style['style'] = strtolower($page);
            $script['script'] = strtolower($page);
        }
        $this->session->set_userdata('page','/'.$page);
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' , $style);
            $this->load->view($this->input->cookie('lang') .'/'. 'pages/' . $page  , $data);
            $this->load->view('templates/footer' , $script);
        }
        else{
            $this->load->view('templates/header' , $style);
            $this->load->view('eng/pages/' . $page , $data);
            $this->load->view('templates/footer' , $script);
        }
        
    }

    public function es()
    {
        $cookie = array(
            'name' => 'lang',
            'value' => 'es',
            'expire' => 31536000
        );
        $this->input->set_cookie($cookie);
        redirect( $this->session->userdata('page') );
    }
    public function fr()
    {
        $cookie = array(
            'name' => 'lang',
            'value' => 'fr',
            'expire' => 31536000
        );
        $this->input->set_cookie($cookie);
        redirect( $this->session->userdata('page') );
    }
    public function ar()
    {
        $cookie = array(
            'name' => 'lang',
            'value' => 'ar',
            'expire' => 31536000
        );
        $this->input->set_cookie($cookie);
        redirect( $this->session->userdata('page') );
    }
    public function eng()
    {
        $cookie = array(
            'name' => 'lang',
            'value' => 'eng',
            'expire' => 31536000
        );
        $this->input->set_cookie($cookie);
        redirect( $this->session->userdata('page') );
    }

    public function contact()
    {
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('subject','Subject','required');
        $this->form_validation->set_rules('message','Message','required');

        if ( $this->form_validation->run() === true ){

            $this->load->config('email');
            $this->load->library('email');

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');    

            $this->email->from( $email , $name );
            $this->email->to( 'onlinesurveyfinalproject@gmail.com', 'OnlineSurvey' );
            $this->email->subject( $subject );
            $this->email->message( $message );
            
            if ($this->email->send()) {
                $this->session->set_flashdata('contact_success' , 'Your message has been sent successfully !');
            } else {
                $this->session->set_flashdata('contact_failed' , 'There has been a problem. Please try again !');
            }

        }

        $style['style'] = 'about';
        $script['script'] = 'about';

        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' , $style);
            $this->load->view($this->input->cookie('lang').'/pages/contact' );
            $this->load->view('templates/footer' , $script);
        }
        else{
            $this->load->view('templates/header' , $style);
            $this->load->view('eng/pages/contact' );
            $this->load->view('templates/footer' , $script);
        }
        
    }
}

?>
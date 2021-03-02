<?php 

class Surveys extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('survey_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in'))
            $id = $this->session->userdata('user_id');
        else
            redirect('/');

        $data['question_forms'] = $this->survey_model->get_question_forms($id);
        $this->load->model('user_model');
        $data['user_img'] = $this->user_model->get_user_img($id);
        $data['url'] = 'http://onlinesurvey.local';

        $this->session->set_userdata('page','/dashboard');
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' ,  array('style' => 'dashboard'));
            $this->load->view($this->input->cookie('lang') . '/app/dashboard' , $data );
            $this->load->view('templates/footer' , array('script' => 'dashboard'));
        }
        else{
            $this->load->view('templates/header' , array('style' => 'dashboard'));
            $this->load->view('eng/app/dashboard' , $data);
            $this->load->view('templates/footer' , array('script' => 'dashboard'));
        }
      
    }

    public function view_survey($form_id)
    {
        if ($this->session->userdata('logged_in')){
            $id = $this->session->userdata('user_id');
            $this->load->model('user_model');
            $data['user_img'] = $this->user_model->get_user_img($id);
            $data['survey_img'] = $this->survey_model->get_survey_img($form_id);
        }
        else
            redirect('/');

        $result = $this->survey_model->get_question_forms($id,$form_id);
        $this->survey_model->see_forms($form_id);
        $data['title']     = $result[0]['title'];
        $data['qf_id']     = $result[0]['question_form_id'];     
        $data['nbr_answers'] = $this->survey_model->count_answers($form_id);
        $data['answers']   = $this->result_to_answers( $this->survey_model->get_answers($data['qf_id']) );
        $questions = $this->result_to_questions($result);
        $multiple_choices = array();
        foreach($questions as $question){
            if ( $question['type'] == 'mcq' || $question['type'] == 'checkbox' ){ 
                $d = array(
                    'id' => $question['id'],
                    'question' => $question['question'],
                    'options'  => $question['options']
                );
                array_push( $multiple_choices , $d );
            }
        }
        $data['questions'] = $questions;
        $data['multiple_choices'] = $multiple_choices;
        $dates = $this->survey_model->get_distinct_dates();
        $d = array();
        foreach($dates as $date){
            $count = $this->survey_model->count_answer_forms( $date['date'] );
            array_push($d , array(
                'date' => $date['date'],
                'count' => $count
            ));
        }
        $data['dates'] = $d;
        $loc = $this->survey_model->getLocations($form_id);
        $locations = array();
        foreach($loc as $l){
            if ($l['country'] !== NULL)
                array_push($locations , $l);
        }
        $data['locations'] = $locations;

        $this->session->set_userdata('page','/view-survey'.'/'.$form_id);
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' ,  array('style' => 'view'));
            $this->load->view($this->input->cookie('lang') . '/app/view' , $data );
            $this->load->view('templates/footer' , array('script' => 'view'));
        }
        else{
            $this->load->view('templates/header' , array('style' => 'view'));
            $this->load->view('eng/app/view' , $data);
            $this->load->view('templates/footer' , array('script' => 'view'));
        }
        
    }

    public function delete_question_form()
    {
        if ( empty($_POST) )
            redirect('/');

        $id = $this->input->post('id');
        $this->survey_model->delete_question_form($id);
        $this->session->set_flashdata('delete-success' , 'Survey Deleted Successfully');
        redirect('/dashboard');
    }

    public function share_form()
    {
        if ( empty($_POST) )
            redirect('/');
        
        $emails_str = $this->input->post('emails');
        $arr = array();
        if ( $emails_str == '' ){
            $arr['empty'] = true;
            echo json_encode($arr);
            exit();
        }

        $emails_array = explode(',' , $emails_str);
        $arr['error'] = false;

        foreach($emails_array as $email){
            if (! filter_var($email , FILTER_VALIDATE_EMAIL) )
                $arr['error'] = true;
            else
                $emails_str = str_replace( $email , '' , $emails_str );
        }

        if ( $arr['error'] ){
            $arr['emails'] = str_replace(',' , ' | ' , $emails_str);
            echo json_encode($arr);
        }
        else{
            $this->load->config('email');
            $this->load->library('email');

            $uuid = $this->survey_model->get_uuid( intval($this->input->post('id')) );
            if ( $this->input->post('name') )
                $username = $this->input->post('name');
            else
                $username = $this->session->userdata('user_name');

            $this->email->from( 'onlinesurveyfinalproject@gmail.com', 'OnlineSurvey' );
            
            $this->email->to( implode(', ' , $emails_array) );

            $this->email->subject('Answer a Form : OnlineSurvey');

            $link = 'http://onlinesurvey.local/answer-survey/' . $uuid;

            if ( file_exists( 'assets/email/email_answer.html') ){
                $this->email->attach( base_url('assets/img/circle-cropped.png') , 'inline');
                $cid = $this->email->attachment_cid(base_url('assets/img/circle-cropped.png'));
                $email = file_get_contents( base_url('assets/email/email_answer.html') );
                $email = str_replace('cid' , 'cid:'.$cid , $email);
                $email = str_replace('http://onlinesurvey.local' , $link , $email);
                $email = str_replace('sender' , ucfirst( $username ) , $email);
                $this->email->message($email);
                
                if ($this->email->send()) {
                    $arr['email-success'] = 'Sending your form to all selected emails !';
                } else {
                    $arr['email_failed'] = "There has been a problem. Please try again";
                }
            }
            else{
                $arr['email_failed'] = "File not found";
            }

            echo json_encode($arr);
        }
    }

    public function create_survey_view()
    {
        $data = array();
        if ( $this->session->userdata('user_id') ){ 
            $id = $this->session->userdata('user_id');
            $this->load->model('user_model');
            $data['user_img'] = $this->user_model->get_user_img($id);
        }
        $data['url'] = 'http://onlinesurvey.local';

        $this->session->set_userdata('page','/create-survey');
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' ,  array('style' => 'survey'));
            $this->load->view($this->input->cookie('lang') . '/app/survey' , $data );
            $this->load->view('templates/footer' , array('script' => 'survey'));
        }
        else{
            $this->load->view('templates/header' , array('style' => 'survey'));
            $this->load->view('eng/app/survey' , $data);
            $this->load->view('templates/footer' , array('script' => 'survey'));
        }
    }

    public function create_survey()
    {
        if ( empty($_POST) )
            redirect('/');

        $data = $this->input->post('data');
        $check = $this->input->post('check');
        $arr = array(
            'error' => false,
        );

        
        if ( count($data) == 1 && array_key_exists(0 , $data) ){
            $arr['error'] = true;
            $arr['empty'] = true;
            echo json_encode($arr);
            exit();
        }
        

        foreach($data as $key => $value){
            for($i=0 ; $i < count($value) ; $i++){
                if ( $data[$key][$i] == '' ){ 
                    if (! array_key_exists('indexes' , $arr) )
                        $arr['indexes'] = array();
                    
                    array_push( $arr['indexes'] , [$key , $i] );
                }
            }
        }

        if (! array_key_exists( 'indexes' , $arr )  ){
            for( $i=1; $i<count($data)-1 ; $i++ ){
                for( $j=$i+1 ; $j<count($data) ; $j++ ){
                    $temp = array_keys($data);
                    if( $data[$temp[$i]][0] == $data[$temp[$j]][0] && $data[$temp[$i]][1] == $data[$temp[$j]][1] ){ 
                        if (! array_key_exists('double' , $arr) )
                            $arr['double'] = array();
                    
                        array_push( $arr['double'] , [ $temp[$i],$temp[$j] ] );
                    }
                }
            }
        }
        
        if ( array_key_exists( 'indexes' , $arr ) || array_key_exists( 'double' , $arr ) ){
            $arr['error'] = true;
        }
        else{
            if ($check == 'false' ){ 
                // Storing in database
                $title = $data[0][0];
                $slug  = url_title($title);
                $user_id = $this->session->userdata('user_id');
                $survey_img = $this->input->post('img');
                $base = ( strpos($survey_img , 'surveys')+strlen('surveys') );
                $survey_img = substr( $survey_img , $base+1 , strlen($survey_img) );
                $form_id = $this->survey_model->store_question_form($title,$slug,$user_id,$survey_img);
                $arr['id'] = $form_id;
                $arr['uuid'] = $this->survey_model->get_uuid($form_id);
                foreach( $data as $key => $quest_array ){
                    if( $key != 0 ){
                        //$quest_array = array_unique($quest_array);
                        $type = $quest_array[0];
                        $question_body = $quest_array[1];
                        $required = $quest_array[2] == 'true' ? 1 : 0;
                        $question_id = $this->survey_model->store_question($type,$question_body,$required,$form_id);
                        if( $type == 'mcq' || $type == 'checkbox' ){
                            $opts = array();
                            for ($i=3;$i < count($quest_array);$i++)
                                array_push($opts , $quest_array[$i]);
            
                            $opts = array_unique($opts);
                            for($i=0;$i<count($opts);$i++)
                                $this->survey_model->store_proposition($opts[$i],$question_id);
                            
                            unset($opts);
                        }
                    }
                }
                $this->session->set_flashdata('create-success' , 'Your form has been created successfully !');
            }
        }
        
        echo json_encode($arr);
    }

    public function update_survey()
    {
        if ( empty($_POST) )
            redirect('/');

        $data = $this->input->post('data');
        $arr = array(
            'error' => false
        );
        if ( count($data) == 1 && array_key_exists(0 , $data) ){
            $arr['error'] = true;
            $arr['empty'] = true;
            echo json_encode($arr);
            exit();
        }
        

        foreach($data as $key => $value){
            for($i=0 ; $i < count($value) ; $i++){
                if ( $data[$key][$i] == '' ){ 
                    if (! array_key_exists('indexes' , $arr) )
                        $arr['indexes'] = [];
                    
                    array_push( $arr['indexes'] , [$key , $i] );
                }
            }
        }
        
        if (! array_key_exists( 'indexes' , $arr )  ){
            for( $i=1; $i<count($data)-1 ; $i++ ){
                for( $j=$i+1 ; $j<count($data) ; $j++ ){
                    $temp = array_keys($data);
                    if( $data[$temp[$i]][0] == $data[$temp[$j]][0] && $data[$temp[$i]][1] == $data[$temp[$j]][1] ){ 
                        if (! array_key_exists('double' , $arr) )
                            $arr['double'] = array();
                    
                        array_push( $arr['double'] , [$i,$j] );
                    }
                }
            }
        }
        
        if ( array_key_exists( 'indexes' , $arr ) || array_key_exists( 'double' , $arr ) ){
            $arr['error'] = true;
        }
        else{
            $title = $data[0][0];
            $slug  = url_title($title);
            $survey_img = $this->input->post('img');
            $form_id = $this->input->post('id');
            $base = ( strpos($survey_img , 'surveys')+strlen('surveys') );
            $survey_img = substr( $survey_img , $base+1 , strlen($survey_img) );
            $this->survey_model->edit_question_form($form_id,$title,$slug,$survey_img);
            $question_orphans = array();
            $proposition_orphans = array();
            foreach( $data as $key => $quest_array ){
                if( $key != 0 ){
                    $type = $quest_array[0];
                    $question_body = $quest_array[1];
                    $required = $quest_array[2] == 'true' ? 1 : 0;
                    if ( $this->survey_model->question_exists($form_id,$question_body,$type) ){
                        $question_id = $this->survey_model->update_question($form_id,$question_body,$required,$type);
                        if( $type == 'mcq' || $type == 'checkbox' ){
                            for ($i=3;$i < count($quest_array);$i++){
                                if ( $this->survey_model->proposition_exists($quest_array[$i],$question_id) == false )
                                    $proposition_id = $this->survey_model->store_proposition($quest_array[$i],$question_id);
                                else 
                                    $proposition_id = $this->survey_model->proposition_exists($quest_array[$i],$question_id);
                                
                                array_push($proposition_orphans,$proposition_id);
                            }
                        }
                        if (! empty($proposition_orphans)){ 
                            $this->survey_model->delete_proposition_orphans(implode(',',$proposition_orphans) , $question_id);
                            unset($proposition_orphans);
                            $proposition_orphans = array();
                        }
                    }
                    else{
                        $question_id = $this->survey_model->store_question($type,$question_body,$required,$form_id);
                        if( $type == 'mcq' || $type == 'checkbox' ){
                            $opts = array();
                            for ($i=3;$i < count($quest_array);$i++)
                                array_push($opts , $quest_array[$i]);
            
                            $opts = array_unique($opts);
                            for($i=0;$i<count($opts);$i++)
                                $this->survey_model->store_proposition($opts[$i],$question_id);
                            
                            unset($opts);
                        }
                    }
                    array_push($question_orphans,$question_id);
                }
            }
            if (! empty($question_orphans) )
                $this->survey_model->delete_question_orphans(implode(',',$question_orphans) , $form_id);

        }
        echo json_encode($arr);
    }

    public function store_survey()
    {
        if ( empty($_POST) )
            redirect('/');

        $data = $this->input->post('data');
        $delete = $this->input->post('delete');

        if ($delete == 'true')
        {
            $this->survey_model->delete_last();
        }

        $title = $data[0][0];
        $slug  = strtolower( url_title($title) );

        if ( $this->input->post('id') )
            $user_id = intval( $this->input->post('id') );
        else
            $user_id = $this->session->userdata('user_id');
        
        $survey_img = $this->input->post('img');
        $base = ( strpos($survey_img , 'surveys')+strlen('surveys') );
        $survey_img = substr( $survey_img , $base+1 , strlen($survey_img) );
        
        $form_id = $this->survey_model->store_question_form($title,$slug,$user_id,$survey_img);
        foreach( $data as $key => $quest_array ){
            if( $key != 0 ){
                $type = $quest_array[0];
                $question_body = $quest_array[1];
                $required = $quest_array[2] == 'true' ? 1 : 0;
                $question_id = $this->survey_model->store_question($type,$question_body,$required,$form_id);
                if( $type == 'mcq' || $type == 'checkbox' ){
                    $opts = array();
                    for ($i=3;$i < count($quest_array);$i++)
                        array_push($opts , $quest_array[$i]);
    
                    $opts = array_unique($opts);
                    for($i=0;$i<count($opts);$i++)
                        $this->survey_model->store_proposition($opts[$i],$question_id);
                    
                    unset($opts);
                }
            }
        }
        $this->session->set_flashdata('create-success' , 'Your form has been created and sent successfully !');

        echo json_encode( array('id' => $form_id) );
    }

   public function upload_image()
   {
        if ( isset($_FILES['userfile']['name']) ){
            $config['upload_path']          = './assets/img/uploads/surveys';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048;
            $config['max_width']            = 1000;
            $config['max_height']           = 1000;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('userfile'))
            {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode($error);
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                echo json_encode($data['upload_data']);
            }

        }
        else
            echo 'error';

   }

   public function answer_survey_view($uuid)
   {
        $result = $this->survey_model->get_by_uuid($uuid);
        $questions = $this->result_to_questions($result);
        $data['questions'] = $questions;
        $data['user']      = $result[0]['user'];
        $data['title']     = $result[0]['title'];
        $data['qf_id']     = $result[0]['question_form_id'];
        $data['url'] = 'http://onlinesurvey.local';

        $this->session->set_userdata('page','/answer-survey'.'/'.$uuid);
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' ,  array('style' => 'survey'));
            $this->load->view($this->input->cookie('lang') . '/app/answer' , $data );
            $this->load->view('templates/footer' , array('script' => 'survey'));
        }
        else{
            $this->load->view('templates/header' , array('style' => 'survey'));
            $this->load->view('eng/app/answer' , $data);
            $this->load->view('templates/footer' , array('script' => 'survey'));
        }
   }

   public function answer_survey()
   {
        if ( empty($_POST) )
            redirect('/');
            
        $questions =  $this->input->post('questions') ;
        $values = $this->input->post('values');
        $qf_id = $this->input->post('qf_id');
        $country = $this->input->post('country');
        $city = $this->input->post('city');
        $lat = $this->input->post('lat');
        $lon = $this->input->post('lon');

        $data = array(
            'error' => false
        );
        $answers = array();

        for ( $i=0 ; $i < count( $questions ) ; $i++ )
        {
            $qst = $questions[$i];
            if ( $qst['type'] == 'mcq' || $qst['type'] == 'checkbox' )
            {
                $cpt = 0;
                for ( $j=0 ; $j < count( $qst['options'] ) ; $j++ )
                {
                    if ( $values[$i][$j] == 'true' ){
                        $cpt++;
                        array_push( $answers , array( 'type' => $qst['type'] , 'body' => $qst['options'][$j] , 'question_id' => $qst['id'] ) );
                    }
                }
                if ($cpt == 0 && $qst['required'] == 1 ){
                    if ( $data['error'] == true ){
                        array_push( $data['indexes'] , $i );
                    }
                    else{ 
                        $data['indexes'] = [$i];
                        $data['error'] = true;
                    }
                }

            }
            elseif ( $qst['type'] == 'range' )
            {
                if ( $qst['required'] == 1 && ( $values[$i][0] == '' || $values[$i][1] == '' ) ){ 
                    if ( $data['error'] == true ){
                        array_push( $data['indexes'] , $i );
                    }
                    else{ 
                        $data['indexes'] = [$i];
                        $data['error'] = true;
                    }
                }
                else
                    array_push( $answers , array( 'type' => $qst['type'] , 'body' => $values[$i][0].','.$values[$i][1] , 'question_id' => $qst['id'] ) );
            }
            else
            {
                if ( $qst['required'] == 1 ){
                    $val = $values[$i];
                    if ( $qst['type'] == 'open' )
                    
                        $val = str_replace(array('.', ' ', "\n", "\t", "\r") , '', str_replace( '&nbsp;','',strip_tags($val) ));

                    if ( $val == '' ){
                        if ( $data['error'] == true ){
                            array_push( $data['indexes'] , $i );
                        }
                        else{ 
                            $data['indexes'] = [$i];
                            $data['error'] = true;
                        }
                    }
                    else 
                        array_push( $answers , array( 'type' => $qst['type'] , 'body' => $values[$i] , 'question_id' => $qst['id'] ) );
                }
                else 
                    array_push( $answers , array( 'type' => $qst['type'] , 'body' => $values[$i] , 'question_id' => $qst['id'] ) );
            }
        }
        
        if ($data['error'] == true){
            echo json_encode($data);
            exit();
        }
        if ( $country == '' )
            $answer_form_id = $this->survey_model->store_answer_form($qf_id);
        else 
            $answer_form_id = $this->survey_model->store_answer_form($qf_id,$country,$city,$lat,$lon);
        
        $this->survey_model->store_answers($answers , $answer_form_id);

        echo json_encode($data);
   }

   public function result_to_answers($result)
   {
       $answers = array();
       foreach($result as $ans)
       {
           if ( empty($answers) ){
               // push form id and array question_id and answer
               $data = array(
                   'answer_form_id' => $ans['answer_form_id'],
                   'answers' => array( array( 'question_id' => $ans['question_id'] , 'answer' => $ans['answer'] ) )
               );
               array_push($answers , $data);
           }
           elseif ( $answers[ count($answers)-1 ]['answer_form_id'] != $ans['answer_form_id'] ){
               // same as empty 
               $data = array(
                'answer_form_id' => $ans['answer_form_id'],
                'answers' => array( array( 'question_id' => $ans['question_id'] , 'answer' => $ans['answer'] ) )
                );
                array_push($answers , $data);
           }
           else{
               // append to answers['answer']
               $data = array(
                'question_id' => $ans['question_id'] , 'answer' => $ans['answer']
               );
               array_push( $answers[ count($answers)-1 ]['answers'] , $data );
           }
       }
       return $answers;
   }

   public function result_to_questions($result)
   {
        $questions = array();
        foreach($result as $question)
        {
            if ( $question['type'] == 'mcq' || $question['type'] == 'checkbox' )
            {
                if ( empty($questions) )
                {
                    $q = array(
                        'id' => $question['question_id'],
                        'question' => $question['question'],
                        'type' => $question['type'],
                        'required' => $question['required'],
                        'options' => array( $question['proposition'] )
                    );
                    array_push( $questions , $q );
                }
                elseif ( $questions[ count($questions)-1 ]['id'] != $question['question_id'] )
                {
                    $q = array(
                        'id' => $question['question_id'],
                        'question' => $question['question'],
                        'type' => $question['type'],
                        'required' => $question['required'],
                        'options' => array( $question['proposition'] )
                    );
                    array_push( $questions , $q );
                }
                else
                {
                    array_push( $questions[ count($questions)-1 ]['options'] , $question['proposition'] );
                }
            }
            else
            {
                $q = array(
                    'id' => $question['question_id'],
                    'question' => $question['question'],
                    'type' => $question['type'],
                    'required' => $question['required'],
                );
                array_push( $questions , $q );
            }
        }
        return $questions;
   }

    public function upgrade_view()
    {
        if ($this->session->userdata('logged_in'))
            $id = $this->session->userdata('user_id');
        else
            redirect('/');

        $this->load->model('user_model');
        $data['user_img'] = $this->user_model->get_user_img($id);
        

        $this->session->set_userdata('page','/upgrade');
        if ( $this->input->cookie('lang') ){
            $this->load->view('templates/header' ,  array('style' => 'price'));
            $this->load->view($this->input->cookie('lang') . '/app/upgrade' , $data );
            $this->load->view('templates/footer' , array('script' => 'price'));
        }
        else{
            $this->load->view('templates/header' , array('style' => 'price'));
            $this->load->view('eng/app/upgrade' , $data);
            $this->load->view('templates/footer' , array('script' => 'price'));
        }
   
    }

}
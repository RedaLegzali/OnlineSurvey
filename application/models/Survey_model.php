<?php 


class Survey_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_question_forms($user_id=FALSE , $form_id=FALSE)
    {
        if ($user_id !== FALSE && $form_id === FALSE)
        {
            $this->db->order_by('created_at' , 'DESC');
            $query =  $this->db->get_where('question_forms' , array('user_id'=>$user_id));
            $result = $query->result_array();
            for ($i=0 ; $i<count($result) ; $i+=1)
            {
                $query1 = $this->db->get_where('answer_forms' , array( 'seen' => 0 , 'question_form_id' => ($result[$i])['id'] ) );
                ($result[$i])['notifications'] = count( $query1->result() );
            }
            return $result;
        }
        elseif ($user_id !== FALSE && $form_id !== FALSE)
        {
            $this->db->select('qf.id as "question_form_id" , qf.title as "title" , q.id as "question_id" ,  q.body as "question" , q.type as "type" , q.required as "required" , p.body as "proposition"');
            $this->db->from('question_forms qf');
            $this->db->join('users u' , 'qf.user_id = u.id');
            $this->db->join('questions q' , 'qf.id = q.question_form_id');
            $this->db->join('propositions p' , 'q.id = p.question_id' , 'left');
            $this->db->where( array('qf.id'=>$form_id , 'u.id' => $user_id) );
            $query = $this->db->get();
            $result = $query->result_array();
            return $result;
        }
    }

    public function getLocations($form_id)
    {
        $this->db->select('country , city , lat , lon');
        $this->db->from('answer_forms');
        $this->db->where('question_form_id' , $form_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_distinct_dates()
    {
        $query = $this->db->query('select distinct( date_format( created_at , "%Y-%m-%d" ) ) as "date" from answer_forms;');
        $result = $query->result_array();
        return $result;
    }

    public function count_answer_forms($date)
    {
        $sql = ' select count(id) as "count" from answer_forms where created_at like ? ;';
        $query = $this->db->query($sql , array($date.'%'));
        $result = $query->row_array();
        return $result['count'];
    }

    public function delete_question_form($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('question_forms');
    }


    public function edit_question_form($id,$title,$slug,$survey_img)
    {
        $data = array(
            'title' => $title,
            'slug' => $slug,
            'survey_img' => $survey_img
        );
        $this->db->where('id' , $id);
        $this->db->update('question_forms',$data);
    }

    public function update_question($qf_id,$question_body,$required,$type)
    {
        $this->db->where( array('question_form_id'=>$qf_id , 'body'=>$question_body,'type'=>$type) );
        $this->db->update( 'questions' , array('required'=>$required) );
        $this->db->select('id');
        $q = $this->db->get_where('questions' , array('question_form_id'=>$qf_id , 'body'=>$question_body,'type'=>$type) );
        $r = $q->row_array();
        return $r['id'];
    }

    public function delete_question_orphans($set,$qf_id)
    {
        $this->db->where( 'id in (select q1.id from questions q1 join questions q2 on q1.id = q2.id where q2.id not in ('.$set.'))' );
        $this->db->where('question_form_id' , $qf_id);
        $this->db->delete('questions');
    }

    public function delete_proposition_orphans($set,$question_id)
    {
        $this->db->where( 'id in (select p1.id from propositions p1 join propositions p2 on p1.id = p2.id where p2.id not in ('.$set.'))' );
        $this->db->where('question_id' , $question_id);
        $this->db->delete('propositions');
    }

    public function question_exists($form_id,$question_body,$type)
    {
        $this->db->select('id');
        $q = $this->db->get_where('questions' , array('body'=>$question_body,'type'=>$type,'question_form_id'=>$form_id));
        if ( empty( $q->row_array() ) )
            return false;
        
        return true;
    }

    public function proposition_exists($proposition,$question_id)
    {
        $this->db->select('id');
        $q = $this->db->get_where('propositions' , array('body'=>$proposition,'question_id'=>$question_id));
        if ( empty( $q->row_array() ) ) 
            return false;
        
        $r = $q->row_array();
        return $r['id'];
    }

    public function get_uuid($id)
    {
        $query = $this->db->get_where('question_forms' , array('id' => $id) );
        $result = $query->row_array();
        return $result['uuid'];
    }

    public function store_question_form($title,$slug,$user_id,$survey_img)
    {
        $data = array(
            'title' => $title,
            'slug' => $slug,
            'user_id' => $user_id,
            'survey_img' => $survey_img
        );
        $this->db->insert('question_forms' , $data);
        return $this->db->insert_id();
    }

    public function store_question($type,$question,$required,$form_id)
    {
        $data = array(
            'type' => $type,
            'required' => $required,
            'body' => $question,
            'question_form_id' => $form_id
        );

        $this->db->insert('questions' , $data);
        return $this->db->insert_id();
    }

    public function store_proposition($proposition,$question_id)
    {   
        $data = array(
            'body' => $proposition,
            'question_id' => $question_id
        );

        $this->db->insert('propositions' , $data);
        return $this->db->insert_id();

    }

    public function store_answer_form($qf_id,$country=FALSE,$city=FALSE,$lat=FALSE,$lon=FALSE)
    {
        if ($country !== FALSE)
            $this->db->insert('answer_forms' , array('question_form_id' => $qf_id , 'country' => $country , 'city' => $city , 'lat' => $lat , 'lon' => $lon));
        else 
            $this->db->insert('answer_forms' , array('question_form_id' => $qf_id));
        
        return $this->db->insert_id();
    }

    public function store_answers($answers , $answer_form_id)
    {
        foreach($answers as $answer){
            $data = array(
                //'body' => $answer['body'],
                'question_id' => $answer['question_id'],
                'answer_form_id' => $answer_form_id
            );
            $this->db->insert('answers' , $data);
            $id = $this->db->insert_id();
            if ( $answer['type'] == 'mcq' || $answer['type'] == 'checkbox' )
                $this->db->insert( 'mcq' , array( 'id'=>$id , 'body'=>$answer['body'] ) );
            elseif ( $answer['type'] == 'open' )
                $this->db->insert( 'open' , array( 'id'=>$id , 'body'=>$answer['body'] ) );
            elseif ( $answer['type'] == 'date' )
                $this->db->insert( 'date' , array( 'id'=>$id , 'body'=>$answer['body'] ) );
            elseif ( $answer['type'] == 'time' )
                $this->db->insert( 'time' , array( 'id'=>$id , 'body'=>$answer['body'] ) );
            elseif ( $answer['type'] == 'range' ){
                $temp = explode(',',$answer['body']);
                $min = $temp[0];
                $max = $temp[1];
                $this->db->insert( 'minmax' , array( 'id'=>$id , 'minimum'=>intval($min) , 'maximum'=>intval($max) ) );
            }
        }
    }

    public function delete_last()
    {
        $this->db->query('delete from question_forms where id = ( select id from question_forms order by id desc limit 1);');
    }

    public function get_by_uuid($uuid)
    {
        $this->db->select( 'u.name as "user", qf.id as "question_form_id" , qf.title as "title" , q.id as "question_id" , q.body as "question" , q.type as "type" , q.required as "required" , p.body as "proposition"');
        $this->db->from('question_forms qf');
        $this->db->join('users u' , 'qf.user_id = u.id');
        $this->db->join('questions q' , 'qf.id = q.question_form_id');
        $this->db->join('propositions p' , 'q.id = p.question_id' , 'left');
        $this->db->where('qf.uuid' , $uuid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_survey_img($form_id)
    {
        $this->db->select('survey_img');
        $query = $this->db->get_where('question_forms' , array('id'=>$form_id));
        $result = $query->row_array();
        return $result['survey_img'];
    }

    public function see_forms($form_id)
    {
        $this->db->where('question_form_id',$form_id);
        $this->db->update('answer_forms' , array('seen'=>1));
    }

    public function get_answers($form_id)
    {
        $this->db->select(' af.id as "answer_form_id" , q.type as "type" , a.id as "id" , a.question_id as "question_id" ');
        $this->db->from('answer_forms af');
        $this->db->join('answers a' , 'af.id = a.answer_form_id');
        $this->db->join('questions q' , 'q.id = a.question_id');
        $this->db->where('af.question_form_id' , $form_id);
        $this->db->order_by('af.id');
        $query = $this->db->get();
        $result = $query->result_array();
        $res = array();
        foreach($result as $answers){
            if ( $answers['type'] == 'mcq' || $answers['type'] == 'checkbox' )
                $answers['answer'] = $this->db->get_where('mcq' , array('id'=>$answers['id']))->row_array()['body'];
            elseif ( $answers['type'] == 'open' )
                $answers['answer'] = $this->db->get_where('open' , array('id'=>$answers['id']))->row_array()['body'];
            elseif ( $answers['type'] == 'date' )
                $answers['answer'] = $this->db->get_where('date' , array('id'=>$answers['id']))->row_array()['body'];
            elseif ( $answers['type'] == 'time' )
                $answers['answer'] = $this->db->get_where('time' , array('id'=>$answers['id']))->row_array()['body'];
            elseif ( $answers['type'] == 'range' ){
                $temp = $this->db->get_where('minmax' , array('id'=>$answers['id']))->row_array();
                $min = $temp['minimum'];
                $max = $temp['maximum'];
                $answers['answer'] = implode(',',array($min,$max));
            }
            array_push( $res , $answers );
        }
        return $res;
    }

    public function count_answers($form_id){
        $this->db->select('count(id) as "count"');
        $q = $this->db->get_where('answer_forms' , array('question_form_id'=>$form_id) );
        return $q->row_array()['count'];
    }

}
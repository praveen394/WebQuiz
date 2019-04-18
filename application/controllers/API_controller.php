<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

/**
 * Controller : API_controller
 *
 * @author Praveen Naresh
 * @2012053
 */
class API_controller extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    //function to get a single question by id
    public function question_get() {
        $id = $this->get('questionId'); //get question id
        $dataBag['single'] = $this->admin_model->getSingleQuestion($id);
        echo json_encode($dataBag); //return results in json
    }
    
    //function to insert question and answers
    public function question_post() {
        //get form data
        $data = array(
            'question' => $this->input->post('question'),
            'choice1' => $this->input->post('choice1'),
            'choice2' => $this->input->post('choice2'),
            'choice3' => $this->input->post('choice3'),
            'choice4' => $this->input->post('choice4'),
            'correctAns' => $this->input->post('correctAns')
        );
        $output = array();
        $result = $this->admin_model->insertQuestion($data);
        if ($result) {
            $output = array('status' => $result);
        } else {
            $output = array('status' => $result);
        }
        //return true/false as json
        echo json_encode($output);
    }
    
    //function to update question and answers
    public function question_put() {
        //get form data
        $data = array(
            'questionID' => $this->put('questionID'),
            'question' => $this->put('question'),
            'choice1' => $this->put('choice1'),
            'choice2' => $this->put('choice2'),
            'choice3' => $this->put('choice3'),
            'choice4' => $this->put('choice4'),
            'correctAns' => $this->put('correctAns')
        );
        $output = array();
        $result = $this->admin_model->updateQuestions($data);
        if ($result) {
            $output = array('status' => $result);
        } else {
            $output = array('status' => $result);
        }
        //return true/false in json
        echo json_encode($output);
    }

    //function to delete question and relevant answers
    public function question_delete() {
        $id = $this->delete('questionId'); //get question id
        $output = array();
        $result = $this->admin_model->DeleteQuestion($id);
        if ($result) {
            $output = array('status' => $result);
        } else {
            $output = array('status' => $result);
        }
        echo json_encode($output);
    }

}

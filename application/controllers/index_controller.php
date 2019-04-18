<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controller : index_controller
 *
 * @author Praveen Naresh
 * @2012053
 */
class index_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('form_validation');
    }
    //function to load the index page
    //clears all session data
    public function index() {
        $session_items = array('user' => '', 'logged_in' => false);
        $this->session->unset_userdata($session_items);
        $this->session->sess_destroy();
        $this->load->view('index');
    }

    //function to load the quiz view
    public function quiz() {
        $this->load->model('quiz_model');
        $load_query = $this->quiz_model->load_quiz();
        $this->load->view('quiz', array('quiz' => $load_query));
    }

    //function to load the results view
    public function results() {
        $this->load->model('quiz_model');
        $output['result'] = $this->quiz_model->validate_answers();
        $this->load->view('results', $output);
    }
    
    //function to validate admin login
    //and redirect to admin_controller
    public function redirect() {
        $this->load->model('quiz_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $sdata = [
            'user' => $username,
            'logged_in' => true
        ];
        $this->session->set_userdata($sdata);
        $data = array();
        $output = $this->quiz_model->validate($username, $password);
        if ($output) {
            $data = array('status' => $output);
        } else {
            $data = array('status' => $output);
        }
        //sending json object to the view
        echo json_encode($data);
    }
    
    //function to set session when the
    //user starts playing the quiz
    public function setSession() {
        $this->load->model('quiz_model');
        $player = $this->input->post('player');
        $id = $this->quiz_model->addUser($player);
        $data = [
            'player' => $player,
            'user_id' => $id
        ];
        $this->session->set_userdata($data);
    }
}

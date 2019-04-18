<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controller : admin_controller
 *
 * @author Praveen Naresh
 * @2012053
 */
class admin_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    //function to load the admin page
    public function index() {
        //get all questions and pass to the view
        $dataBag['all'] = $this->admin_model->getAllQuestions();
        $this->load->view('admin_page', $dataBag);
    }

}

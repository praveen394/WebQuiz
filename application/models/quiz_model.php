<?php
/**
 * Model : quiz_model
 *
 * @author Praveen Naresh
 * @2012053
 */
class quiz_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    /**
     * Function to authenticate the admin
     * @return boolean
     */
    function validate($username, $password) {
        $this->load->database();
        //check user credentials and isAdmin
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('isAdmin',TRUE);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Function to load the quiz
     * @return quiz array()
     */
    function load_quiz() {
        $this->load->database();
        $get_random_questions = $this->db->query("SELECT distinct id "  //getting 10 random questions
                . "FROM questions "
                . "ORDER BY RAND() "
                . "LIMIT 10");
        $random_id = '';
        $counter = 0;
        foreach ($get_random_questions->result() as $row) { //storing the random question id's to an array
            $counter++;
            if ($counter == 10) {
                $random_id.=$row->id;
            } else {
                $random_id.=$row->id . ',';
            }
        }
        $load_query = $this->db->query("SELECT * " //getting all answers for each random question
                . "FROM questions LEFT OUTER JOIN answers "
                . "ON questions.id = answers.questionID "
                . "WHERE id IN (" . $random_id . ") "       //passing the array of random question id
                . "ORDER BY id");
        $question_id = 0;
        $quiz = array();

        //creating a multidimension array to hold questionid, question and an array of answers for each question
        foreach ($load_query->result() as $row) {
            if ($question_id != $row->id) { //based on each question add the elements
                $question_id = $row->id; //add the question id, question and the answer from the first iteration
                $quiz[$question_id] = array('id' => $row->id, 'text' => $row->text, 'val' => $row->ans_id,
                    'ans' => array($row->ans_id => array('ansid' => $row->ans_id, 'choice' => $row->ans_text)));
            } else { //add only the remaining answers under the particular question
                $quiz[$question_id]['ans'][$row->ans_id] = array('ansid' => $row->ans_id, 'choice' => $row->ans_text);
            }
        }
        return $quiz;
    }

    /**
     * Function to validate the form
     * @return array
     */
    function validate_answers() {
        $this->load->database();
        $is_incorrect = array(); // array to hold incorrect answers
        $correct_questions = 0;
        $incorrect_questions = 0;
        $total_questions = 10;
        $final_message = '';
        for ($i = 1; $i < 11; $i++) {
            $form_name_value = '';
            //get the value field from the form. Value field holds questionid and answerid separated by a ','
            $form_name_value = $this->input->post($i);
            //split using delimeter ',' and get both values
            list($id, $a_id) = array_pad(explode(',', $form_name_value, 2), 2, NULL);
            $question_id = (int) $id; //cast as int
            $answer_id = (int) $a_id;
            //check if selected answer is correct
            $is_correct = $this->get_correct_answer($question_id, $answer_id);
            if ($is_correct) {
                $correct_questions +=10; //add 10 for each correct answer
            } else {
                $incorrect_questions +=1; //increment the incorrect questions counter
                $is_incorrect [] = $this->get_incorrect_questions($question_id, $answer_id);
            }
        } //get the message to display as per user's score
        $this->saveScore($correct_questions);
        $score = $this->getScores();
        $final_message = $this->get_result_message($correct_questions);
        $player = $this->session->userdata("player");
        return array('correct' => $correct_questions,
            'incorrect' => $incorrect_questions,
            'total' => $total_questions,
            'message' => $final_message, 'answers' => $is_incorrect, 'scores' => $score, 'player' => $player);
    }

    /**
     * Function to check if the selected answer is correct
     * using the questionid and answerid
     * @return boolean
     */
    function get_correct_answer($questionId, $id) {
        $sql = "SELECT isCorrect "
                . "FROM answers "
                . "where ans_id=" . $id . " "
                . "AND questionID=" . $questionId . "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) { //check if there is any return
            $row = $query->row('isCorrect'); //validate
            if ($row) {
                return TRUE;
            } else {
                return FAlSE;
            }
        } else {
            return FAlSE;
        }
    }

    /**
     * Function to get all the incorrect questions
     * using the questionid and answerid
     * @return type
     */
    function get_incorrect_questions($questionId, $ansId) {
        $result = array();
        //get the correct answer
        $correct_answer_sql = "SELECT questions.text,answers.ans_text "
                . "FROM questions JOIN answers "
                . "ON questions.id = answers.questionID "
                . "WHERE questions.id =" . $questionId . " "
                . "AND answers.isCorrect = 1";
        //get the answer selected by the user
        $selected_answer = "SELECT answers.ans_text "
                . "FROM answers "
                . "WHERE answers.questionID=" . $questionId . " "
                . "AND answers.ans_id =" . $ansId . "";
        $correct_answer = $this->db->query($correct_answer_sql);
        $selected_answer = $this->db->query($selected_answer);
        if ($correct_answer->num_rows() > 0) {
            //add those to an array which holds correct answer
            foreach ($correct_answer->result() as $row) {
                $result = array(
                    'question' => $row->text,
                    'answer' => $row->ans_text,
                );
            }//an element inside an array which holds the user selected value
            foreach ($selected_answer->result() as $row) {
                $result['selected'] = $row->ans_text;
            }
        }
        return $result;
    }

    /**
     * Function to get the message to display to the user based on his/her marks
     * @return string
     */
    function get_result_message($marks) {
        $message = '';
        if ($marks == 100) {
            $message = '<h3>Excellent!<br>You are truly a legendary wizard!</h3>';
        } else if ($marks >= 80 && $marks < 100) {
            $message = '<h3>Great!<br>You are the half blooded prince!</h3>';
        } else if ($marks >= 60 && $marks < 80) {
            $message = '<h3>Well done!<br>You are an amateur wizard!</h3>';
        } else if ($marks >= 40 && $marks < 60) {
            $message = '<h3>Good!<br>Go back to Hogwarts! You can do better!</h3>';
        } else if ($marks >= 20 && $marks < 40) {
            $message = '<h3>Average!<br>Maybe you can guard the castle!</h3>';
        } else if ($marks > 0 && $marks < 20) {
            $message = '<h3>Bad!<br>Muggle tests are for you!</h3>';
        } else {
            $message = '<h3>Very bad!<br>Magic is not for you! Avada Kedavra!!</h3>';
        }

        return $message;
    }
    
    /**
     * Function to add a player to the users table
     * @return integer
     */
    function addUser($username)
    {
        $this->load->database();
        $player = array(
            'username' => $username
        );
        $this->db->insert('users', $player);
        $playerid = $this->db->insert_id();
        //return id to store in session
        return $playerid;
    }

    /**
     * Function to save the players score
     * @return none
     */
    function saveScore($score) {
        $player = $this->session->userdata("player");
        $userid = $this->session->userdata("user_id");
        $data = array(
            'score' => $score,
            'userid' => $userid
        );
        
        $this->db->insert('results',$data);
    }
    
    /**
     * Function to quiz scores
     * @return array
     */
    function getScores(){
        $this->db->select('results.score, users.username');
        $this->db->from('results');
        $this->db->join('users', 'users.id = results.userid');
        $this->db->order_by('results.score','desc');
        
        $query = $this->db->get();
        
        return $query->result();
    }
}

<?php
/**
 * Model : admin_model
 *
 * @author Praveen Naresh
 * @2012053
 */
class admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Function get all question
     * @return array
     */
    function getAllQuestions() {
        $query = $this->db->get('questions');
        return array('questions' => $query->result());
    }
    
    /**
     * Function insert questions and answers
     * @return boolean
     */
    function insertQuestion($parameters) {
        //insert question
        $question = array(
            'text' => $parameters['question']
        );
        $this->db->insert('questions', $question);
        $id = $this->db->insert_id();
        //insert answers
        $answer = array();
        try { //insert answers based on which is the correct answer
            switch ($parameters['correctAns']) {
                case 1:
                    $answer = array(
                        array(
                            'ans_text' => $parameters['choice1'],
                            'isCorrect' => 1,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice2'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice3'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice4'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        )
                    );//insert array batch
                    $this->db->insert_batch('answers', $answer);
                    break;
                case 2:
                    $answer = array(
                        array(
                            'ans_text' => $parameters['choice1'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice2'],
                            'isCorrect' => 1,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice3'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice4'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        )
                    );
                    $this->db->insert_batch('answers', $answer);
                    break;
                case 3:
                    $answer = array(
                        array(
                            'ans_text' => $parameters['choice1'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice2'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice3'],
                            'isCorrect' => 1,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice4'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        )
                    );
                    $this->db->insert_batch('answers', $answer);
                    break;

                case 4:
                    $answer = array(
                        array(
                            'ans_text' => $parameters['choice1'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice2'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice3'],
                            'isCorrect' => 0,
                            'questionID' => $id
                        ),
                        array(
                            'ans_text' => $parameters['choice4'],
                            'isCorrect' => 1,
                            'questionID' => $id
                        )
                    );
                    $this->db->insert_batch('answers', $answer);
                    break;
            }//if successful return true
            return true;
        } catch (Exception $ex) {//else false
            return false;
        }
    }
    
    /**
     * Function get the 4 answers for a particular question
     * using questionid
     * @return array
     */
    function getSingleQuestion($id) {
        $this->db->select('ans_text,isCorrect');
        $this->db->from('answers');
        $this->db->where('questionID', $id);
        $result = $this->db->get();
        $editArray = array();
        $counter = 1;
        //add the answers to an array and return
        foreach ($result->result() as $row) {
            $editArray[$counter] = array(
                'text' => $row->ans_text,
                'correct' => $row->isCorrect
            );
            $counter++;
        }
        return $editArray;
    }
    
    /**
     * Function update question and answers
     * @return boolean
     */
    function updateQuestions($parameters) {
        $id = $parameters['questionID'];
        $answer = array();
        //check if question exists
        $validate = $this->validateQuestion($id);
        if($validate)
        {//update question text
            try {
            $question = array(
                'text' => $parameters['question']
            );
            $this->db->where('id', $id);
            $this->db->update('questions', $question);
            //get the 4 answer id based on the question id
            $ids = $this->getIds($id);
            //update answers based on isCorrect
            $correctAns = (int) $parameters['correctAns'];
            $counter = 5;
            if ($correctAns == 1) {
                $choice1 = array(
                    'ans_text' => $parameters['choice1'],
                    'isCorrect' => 1
                );
                $this->updateQuery($ids[0], $choice1);
                
                $choice2 = array(
                    'ans_text' => $parameters['choice2'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[1], $choice2);
                
                $choice3 = array(
                    'ans_text' => $parameters['choice3'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[2], $choice3);
                
                $choice4 = array(
                    'ans_text' => $parameters['choice4'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[3], $choice4);
                
            } else if ($correctAns == 2) {
                $choice1 = array(
                    'ans_text' => $parameters['choice1'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[0], $choice1);
                
                $choice2 = array(
                    'ans_text' => $parameters['choice2'],
                    'isCorrect' => 1
                );
                $this->updateQuery($ids[1], $choice2);
                
                $choice3 = array(
                    'ans_text' => $parameters['choice3'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[2], $choice3);
                
                $choice4 = array(
                    'ans_text' => $parameters['choice4'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[3], $choice4);
            } else if ($correctAns == 3) {
                $choice1 = array(
                    'ans_text' => $parameters['choice1'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[0], $choice1);
                
                $choice2 = array(
                    'ans_text' => $parameters['choice2'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[1], $choice2);
                
                $choice3 = array(
                    'ans_text' => $parameters['choice3'],
                    'isCorrect' => 1
                );
                $this->updateQuery($ids[2], $choice3);
                
                $choice4 = array(
                    'ans_text' => $parameters['choice4'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[3], $choice4);
            } else {
                $choice1 = array(
                    'ans_text' => $parameters['choice1'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[0], $choice1);
                
                $choice2 = array(
                    'ans_text' => $parameters['choice2'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[1], $choice2);
                
                $choice3 = array(
                    'ans_text' => $parameters['choice3'],
                    'isCorrect' => 0
                );
                $this->updateQuery($ids[2], $choice3);
                
                $choice4 = array(
                    'ans_text' => $parameters['choice4'],
                    'isCorrect' => 1
                );
                $this->updateQuery($ids[3], $choice4);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
        }
        else
        {//if update fails return false
            return false;
        }
    }
    
    /**
     * Function check if question exists before updating
     * @return boolean
     */
    function validateQuestion($id)
    {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('questions');
        $this->db->where('id', $id);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Function get the 4 answer id
     * for a particular questionid
     * @return array
     */
    function getIds($id)
    {
        $this->db->select('ans_id');
        $this->db->from('answers');
        $this->db->where('questionID',$id);
        $query = $this->db->get();
        $answers = array();
        //add the id to an array
        foreach($query->result() as $row)
        {
            $answers[] = $row->ans_id;
        }
        return $answers;
    }

    /**
     * Function query to update answer table
     * @return none
     */
    function updateQuery($id, $data) {
        $this->db->where('ans_id', $id);
        $this->db->update('answers', $data);
    }

    /**
     * Function delete question and answer
     * based on questionid
     * @return boolean
     */
    function DeleteQuestion($id) {
        try {
            $this->db->where('questionID', $id);
            $this->db->delete('answers');

            $this->db->where('id', $id);
            $this->db->delete('questions');

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

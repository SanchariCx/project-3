<?php
class Usermodel extends CI_Model
{   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    public function getUser($email,$password)
    {   $logged_in = FALSE;
        $q = $this->db->where([
                            'email' => $email,
                            'password' => $password
                         ])
                 ->get('users');
        $result = $q->row_array();         
    
       return $result;       
    }
    public function checkDuplicate(String $email)
    {
        $status = TRUE;
        $q   = $this->db->where([
                            'email'=>$email,
                            ])
                ->get('users');
        $result = $q->row();
        if($result)
        {
            $status = FALSE;
        }

    return $status;    
    }
    public function registerUser(array $details)
    {
        $status = FALSE;
        
        

    }

}
?>
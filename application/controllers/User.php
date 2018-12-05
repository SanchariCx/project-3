<?php
class User extends CI_Controller
{
    public function index()
    {   
        // $data = [];
        // $this->load->model('usermodel');
        // $data['user'] = $this->usermodel->getUser();
        // $this->load->view('UserView',$data);
       
    }
    public function login()
    {  $data['maincontent'] = 'loginform'; 
        $this->load->view('includes/template',$data);
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        if($email!=NULL && $password!=NULL)
        {
            $this->_validatecredentials($email,$password);
        }
    }
    private function _validatecredentials(String $email,String $password)
    {
        $this->load->model('usermodel');
        $data = $this->usermodel->getUser($email,$password);
       $userid = $data['id'];
       $this->session->set_userdata('id',$userid);
        redirect('/album');   
    }
   
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login','refresh');
    }
       
}
?>
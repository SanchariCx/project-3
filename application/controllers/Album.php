<?php
class Album extends CI_Controller
{   public function __construct()
    { 
        parent::__construct();
        // $this->output->enable_profiler(TRUE);
    }
    public function index()
    { $userid = $this->session->userdata('id');     
        if(isset($userid))
        {   
        
            $this->getalbums($userid);
        }
        else
        {
            redirect('user/login');
        }
    }
    public function getalbums(int $user_id)
    {
        
        // $this->load->model('albummodel');
        // $data['album_details'] = $this->albummodel->fetchalbum($user_id);
        $data['maincontent'] = 'profile';
        $this->load->view('includes/template',$data);

    }
    public function createalbum()
    {  
        $userid = $_SESSION['id'];
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $time = date("Y:m:d H:i:s");
        if($name!=NULL && $description!=NULL && $userid!=NULL)
        {
            $this->load->model('albummodel');
            $status =  $this->albummodel->createalbum([
                'name'=>$name,
                'user_id'=>$userid,
                'description'=>$description,
                'created_at'=>$time,
                'updated_at'=>$time,
            ]);
            echo $status;
        }
    }
    public function fetchalbums()
    {
        $user_id = $this->session->userdata('id');
        $this->load->model('albummodel');
        $data['album_details'] = $this->albummodel->fetchalbum($user_id);
        echo json_encode($data);
    
    }
    

    public function update()
    {   
        $album_id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
       $time = date("Y:m:d H:i:s");
       if($name!=null & $description!=null)
       {    
            $this->load->model('albummodel');
           $status =  $this->albummodel->updatealbum($album_id,[
                'name'=>$name,
                'description'=>$description,
                'updated_at'=>$time,
            ]);
           echo $status;
       }
    }
   
}
?>
<?php
class Album extends CI_Controller
{   public function __construct()
    { 
        parent::__construct();
        $this->output->enable_profiler(TRUE);
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
        
        $this->load->model('albummodel');
        $data['album_details'] = $this->albummodel->fetchalbum($user_id);
        $data['maincontent'] = 'profile';
        $this->load->view('includes/template',$data);

    }
    public function createalbum()
    {   print_r($_SESSION);
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
            if($status)
            {
             redirect('/album');
            }
        }
        

    }
    public function update(int $album_id)
    {
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
            if($status)
            {
              $this->index();
            }
       }
    }
}
?>
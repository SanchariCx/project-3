<?php
class Image extends CI_Controller
{   public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','file'));
    }
    public function index()
    {
       

    }
    public function getimages($id)
    {  
        $this->load->model('imagemodel');
        $data['images'] = $this->imagemodel->fetchimage($id);
        $this->load->model('albummodel');
        $data['album']=$this->albummodel->getalbumdetails($id);
        $data['maincontent'] = 'gallery';
        $this->load->view('includes/template',$data);
    }
    public function do_upload(int $album_id)
    {   
        
        $config['upload_path'] = './images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $files_ext =  explode("/",$_FILES['album-image']['type']);
        $extension = $files_ext[1];
        $image_name =  str_replace('.',"",microtime(TRUE));
        // $image_name.=".";
        // $image_name.=$extension;
        $config['file_name'] = $image_name;
        $this->load->library('upload',$config);
        if($this->upload->do_upload('album-image'))
        {   
           $ext = $this->upload->data('file_ext');  
           $size = $this->upload->data('file_size');  
           $mime = $this->upload->data('file_type');
           $original_name = $_FILES['album-image']['name'];
           $user_id = $this->session->userdata('id');
           $view_status = $this->input->post('view_status');
           $caption = $this->input->post('caption');
           $time = date("Y:m:d H:i:s"); 
           $this->load->model('imagemodel');
           $status = $this->imagemodel->imageupload([
               'caption'=>$caption,
               'size'=>$size,
               'ext'=>$extension,
               'mime'=>$mime,
               'original_name'=>$original_name,
               'user_id'=>$user_id,
               'album_id'=>$album_id,
               'image_name'=>$image_name,
               'created_at'=>$time,
               'updated_at'=>$time,
               'view_status'=>$view_status
           ]);
           if($status)
           {

            $thumb_status = $this->thumbnailCreation($this->upload->data('full_path'));
            if($thumb_status)
            {
                redirect('image/getimages/'.$album_id);
            }
                  
           }
           

        }
    }
        
    public function thumbnailCreation(string $image_path)
    {  $target_path = './images/thumbnail/';
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_path;
        $config['new_image'] = $target_path;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        $config['height'] = 150;
        // $cong['thumb_marker'] = FALSE;
        $this->load->library('image_lib',$config);
        $status = $this->image_lib->resize();

    return $status;    
    }
    public function softdelete(int $id)
    {
       if(!empty($id))
       {   $time = date('Y:m:d H:i:s');
           $this->load->model('imagemodel');
          $status =  $this->imagemodel->softdelete($id,[
                                            'deleted_at'=>$time,
                                            ]);
          if($status)
          {
              redirect('/album');
          }                                  
       }
    }
    public function trash(int $album_id)
    {
        if(!empty($album_id))
        {
            $this->load->model('imagemodel');
            $data['trashed_data'] = $this->imagemodel->viewdeletedimage($album_id);
            $data['maincontent'] = 'trash';
           $this->load->view('includes/template',$data);
        }
    }
    public function trashdelete(int $imageid)
    {
        if(!empty($imageid))
        {
            $this->load->model('imagemodel');
            $status = $this->imagemodel->imagedelete($imageid);
        }
    }

}


?>
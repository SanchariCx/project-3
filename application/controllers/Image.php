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
    public function getgallery()
    {
        $data['maincontent'] = 'gallery';
        $this->load->view('includes/template',$data);
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
    public function fetchimages()
    {   $id = $this->input->post('albumid');
        $this->load->model('imagemodel');
        $data['images'] = $this->imagemodel->fetchimage($id);
        echo json_encode($data); 
    }
    public function fetchPublicImages()
    {
        $this->load->model('imagemodel');
        $data['images'] = $this->imagemodel->GuestGallery();
        echo json_encode($data);
    }

    public function do_upload()
    {   
        
        $album_id = $this->input->post('album_id');
        $config['upload_path'] = './images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $files_ext =  explode("/",$_FILES['album-image']['type']);
        $extension = $files_ext[1];
        $image_name =  str_replace('.',"",microtime(TRUE));
        $image_name.=".";
        $image_name.=$extension;
        $config['file_name'] = $image_name;
        $this->load->library('upload',$config);
        if(!$this->upload->do_upload('album-image'))
        {
             $error = $this->upload->display_errors();
             $this->session->set_flashdata('error',$error);
             redirect('image/getimages/'.$album_id);
        }   
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
            echo $thumb_status;
                  
           }
           

        

    }
        
    public function thumbnailCreation(string $image_path)
    {  $target_path = './images/thumbnail/';
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_path;
        $config['new_image'] = $target_path;
        //$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        $config['height'] = 150;
        $cong['thumb_marker'] = '';
        $this->load->library('image_lib',$config);
        $status = $this->image_lib->resize();

    return $status;    
    }
    public function softdelete()
    {   
        if(empty($this->session->userdata['id']))
        {
            $this->getgallery();
        }
        $id = $this->input->post('id'); 
       if(!empty($id))
       {   $this->load->model('imagemodel');
           $album_id = $this->imagemodel->fetchid($id);
           $time = date('Y:m:d H:i:s');
          $status =  $this->imagemodel->softdelete($id,
                                            [
                                            'deleted_at'=>$time,
                                            ]);
          if($status)
          {
              redirect('album/');
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
            $album_id = $this->imagemodel->fetchid($imageid);
            $albumid = $album_id[0]['album_id'];
            $image_name = $this->input->post('imagename');
            $extension = $this->input->post('extension');
            $image_folder ='images/'.$image_name.'.'.$extension;
            $thumbnail_folder = 'images/thumbnail/'.$image_name.'_thumb.'.$extension;
            $status = $this->imagemodel->imagedelete($imageid);
            if($status)
            {   
                $image_status = unlink(FCPATH.$image_folder);
                $thumbnail_status = unlink(FCPATH.$thumbnail_folder);
                if($image_status ==TRUE && $thumbnail_status ==TRUE)
                {
                    redirect('/image/trash/'.$albumid);
                }
            }
        }
    }

}


?>
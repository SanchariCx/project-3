<?php
class Imagemodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index()
    {

    }
    public function fetchimage(int $albumid)
    {
        $q = $this->db->where([
            'album_id' => $albumid,
            'deleted_at'=>NULL,    
         ])
        ->get('images');
    $result = $q->result_array(); 
    return $result;
    }
    public function imageupload(array $imagedetails)
    {
        $status = $this->db->insert('images',$imagedetails);
    return $status;    
    }
    public function softdelete(int $image_id,array $delete_details)
    {
        $status = $this->db->where('id',$image_id)
                            ->update('images',$delete_details);
    return $status;
    }
    public function viewdeletedimage(int $album_id)
    {
        $q = $this->db->where([
            'album_id'=>$album_id,
            'deleted_at!='=>null,

        ])
                   ->get('images');
                   $result = $q->result_array();
    return $result;                          
    }
    public function imagedelete(int $image_id)
    {
        $status = $this->db->where([
                'id'=>$image_id,
        ])
                ->delete('images');

    return $status;         
    }
    public function fetchid(int $image_id)
    {
        $q = $this->db->where([
            'id'=>$image_id,
        ])
            ->get('images');
        $result = $q->result_array();    
    return $result;
    }
    public function GuestGallery()
    {
        $q = $this->db->where([
            'view_status'=>1,
            'deleted_at'=>NULL,
        ])
                ->get('images');
                $result = $q->result_array();
    return $result;            
    }

}
?>
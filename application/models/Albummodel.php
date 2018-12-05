<?php
class Albummodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    public function index()
    {
       
    }
    public function fetchalbum(int $user_id)
    {
        $q = $this->db->where([
            'user_id' =>$user_id,
            
         ])
        ->get('albums');
    $result = $q->result_array(); 
    return $result;
    }
    public function createalbum(array $albumdetails)
    {
    $status =  $this->db->insert('albums',$albumdetails);
    return $status;
    }
    public function getalbumdetails(int $album_id)
    {
        $q = $this->db->where([
            'id'=>$album_id,
        ])
        ->get('albums');
        $result = $q->result_array();
        return $result;
    }
    public function updatealbum(int $album_id,array $album_details)
    {
         $status = $this->db->where('id',$album_id)
                  ->update('albums',$album_details);
        return $status;
    }
}
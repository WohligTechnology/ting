<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class video_model extends CI_Model
{
public function create($order,$videourl,$title)
{
$data=array("order" => $order,"videourl" => $videourl,"title" => $title);
$query=$this->db->insert( "ting_video", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("ting_video")->row();
return $query;
}
function getsinglevideo($id){
$this->db->where("id",$id);
$query=$this->db->get("ting_video")->row();
return $query;
}
public function edit($id,$order,$videourl,$title)
{
$data=array("order" => $order,"videourl" => $videourl,"title" => $title);
$this->db->where( "id", $id );
$query=$this->db->update( "ting_video", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `ting_video` WHERE `id`='$id'");
return $query;
}
}
?>

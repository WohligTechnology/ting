<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class apps_model extends CI_Model
{
public function create($order,$image,$title)
{
$data=array("order" => $order,"image" => $image,"title" => $title);
$query=$this->db->insert( "ting_apps", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("ting_apps")->row();
return $query;
}
function getsingleapps($id){
$this->db->where("id",$id);
$query=$this->db->get("ting_apps")->row();
return $query;
}
public function edit($id,$order,$image,$title)
{
$data=array("order" => $order,"image" => $image,"title" => $title);
$this->db->where( "id", $id );
$query=$this->db->update( "ting_apps", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `ting_apps` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `ting_apps` WHERE `id`='$id'")->row();
		return $query;
	}
}
?>

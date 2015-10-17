<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class website_model extends CI_Model
{
public function create($order,$type,$image,$title)
{
$data=array("order" => $order,"type" => $type,"image" => $image,"title" => $title);
$query=$this->db->insert( "ting_website", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("ting_website")->row();
return $query;
}
function getsinglewebsite($id){
$this->db->where("id",$id);
$query=$this->db->get("ting_website")->row();
return $query;
}
public function edit($id,$order,$type,$image,$title)
{
$data=array("order" => $order,"type" => $type,"image" => $image,"title" => $title);
$this->db->where( "id", $id );
$query=$this->db->update( "ting_website", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `ting_website` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `ting_website` WHERE `id`='$id'")->row();
		return $query;
	}

}
?>

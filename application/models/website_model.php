<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class website_model extends CI_Model
{
public function create($order,$type,$image,$title)
{
$data=array("order" => $order,"image" => $image,"title" => $title);
$query=$this->db->insert( "ting_website", $data );
$websiteid=$this->db->insert_id();

foreach ($type as $key => $value)
{
    $data=array("type" => $value,"website" => $websiteid);
	$query=$this->db->insert( "type", $data );
	$id=$this->db->insert_id();
}
return  1;
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
$data=array("order" => $order,"image" => $image,"title" => $title);
$this->db->where( "id", $id );
$query=$this->db->update( "ting_website", $data );
$query=$this->db->query("DELETE FROM `type` WHERE `website`='$id'");
foreach ($type as $key => $value)
{
    $data=array("type" => $value,"website" => $id);
	$query1=$this->db->insert( "type", $data );
	$typeid=$this->db->insert_id();
}
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
	public function gettypes($id)
	{
		$query=$this->db->query("SELECT `type` FROM `type` WHERE `website`='$id'")->result();
        $return=array();
        foreach($query as $row)
        {
            array_push($return,$row->type);
        }
		return $return;
	}

}
?>

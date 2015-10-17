<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class digitalmarketing_model extends CI_Model
{
public function create($order,$image,$facebooklink,$twitterlink,$googlelink,$linkedinlink,$instagramlink,$youtubelink,$pinterestlink)
{
$data=array("order" => $order,"image" => $image,"facebooklink" => $facebooklink,"twitterlink" => $twitterlink,"googlelink" => $googlelink,"linkedinlink" => $linkedinlink,"instagramlink" => $instagramlink,"youtubelink" => $youtubelink,"pinterestlink" => $pinterestlink);
$query=$this->db->insert( "ting_digitalmarketing", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("ting_digitalmarketing")->row();
return $query;
}
function getsingledigitalmarketing($id){
$this->db->where("id",$id);
$query=$this->db->get("ting_digitalmarketing")->row();
return $query;
}
public function edit($id,$order,$image,$facebooklink,$twitterlink,$googlelink,$linkedinlink,$instagramlink,$youtubelink,$pinterestlink)
{
$data=array("order" => $order,"image" => $image,"facebooklink" => $facebooklink,"twitterlink" => $twitterlink,"googlelink" => $googlelink,"linkedinlink" => $linkedinlink,"instagramlink" => $instagramlink,"youtubelink" => $youtubelink,"pinterestlink" => $pinterestlink);
$this->db->where( "id", $id );
$query=$this->db->update( "ting_digitalmarketing", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `ting_digitalmarketing` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `ting_digitalmarketing` WHERE `id`='$id'")->row();
		return $query;
	}
}
?>

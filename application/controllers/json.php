<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallvideo()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_video`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`ting_video`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`ting_video`.`videourl`";
$elements[2]->sort="1";
$elements[2]->header="Video Url";
$elements[2]->alias="videourl";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`ting_video`.`title`";
$elements[3]->sort="1";
$elements[3]->header="Title";
$elements[3]->alias="title";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_video`");
$this->load->view("json",$data);
}
public function getsinglevideo()
{
$id=$this->input->get_post("id");
$data["message"]=$this->video_model->getsinglevideo($id);
$this->load->view("json",$data);
}
function getalldigitalmarketing()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_digitalmarketing`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`ting_digitalmarketing`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`ting_digitalmarketing`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`ting_digitalmarketing`.`facebooklink`";
$elements[3]->sort="1";
$elements[3]->header="Facebook Link";
$elements[3]->alias="facebooklink";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`ting_digitalmarketing`.`twitterlink`";
$elements[4]->sort="1";
$elements[4]->header="Twitter Link";
$elements[4]->alias="twitterlink";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`ting_digitalmarketing`.`googlelink`";
$elements[5]->sort="1";
$elements[5]->header="Google Link";
$elements[5]->alias="googlelink";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`ting_digitalmarketing`.`linkedinlink`";
$elements[6]->sort="1";
$elements[6]->header="Linkedin Link";
$elements[6]->alias="linkedinlink";

$elements=array();
$elements[7]=new stdClass();
$elements[7]->field="`ting_digitalmarketing`.`instagramlink`";
$elements[7]->sort="1";
$elements[7]->header="Instagram Link";
$elements[7]->alias="instagramlink";

$elements=array();
$elements[8]=new stdClass();
$elements[8]->field="`ting_digitalmarketing`.`youtubelink`";
$elements[8]->sort="1";
$elements[8]->header="Youtube Link";
$elements[8]->alias="youtubelink";

$elements=array();
$elements[9]=new stdClass();
$elements[9]->field="`ting_digitalmarketing`.`pinterestlink`";
$elements[9]->sort="1";
$elements[9]->header="Pinterest Link";
$elements[9]->alias="pinterestlink";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_digitalmarketing`");
$this->load->view("json",$data);
}
public function getsingledigitalmarketing()
{
$id=$this->input->get_post("id");
$data["message"]=$this->digitalmarketing_model->getsingledigitalmarketing($id);
$this->load->view("json",$data);
}
function getallapps()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_apps`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`ting_apps`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`ting_apps`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`ting_apps`.`title`";
$elements[3]->sort="1";
$elements[3]->header="Title";
$elements[3]->alias="title";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_apps`");
$this->load->view("json",$data);
}
public function getsingleapps()
{
$id=$this->input->get_post("id");
$data["message"]=$this->apps_model->getsingleapps($id);
$this->load->view("json",$data);
}
function getallwebsite()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_website`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`ting_website`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`ting_website`.`type`";
$elements[2]->sort="1";
$elements[2]->header="Type";
$elements[2]->alias="type";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`ting_website`.`image`";
$elements[3]->sort="1";
$elements[3]->header="Image";
$elements[3]->alias="image";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`ting_website`.`title`";
$elements[4]->sort="1";
$elements[4]->header="Title";
$elements[4]->alias="title";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_website`");
$this->load->view("json",$data);
}
public function getsinglewebsite()
{
$id=$this->input->get_post("id");
$data["message"]=$this->website_model->getsinglewebsite($id);
$this->load->view("json",$data);
}
} ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
    public function viewvideo()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewvideo";
$data["base_url"]=site_url("site/viewvideojson");
$data["title"]="View video";
$this->load->view("template",$data);
}
function viewvideojson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_video`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`ting_video`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`ting_video`.`videourl`";
$elements[2]->sort="1";
$elements[2]->header="Video Url";
$elements[2]->alias="videourl";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_video`");
$this->load->view("json",$data);
}

public function createvideo()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createvideo";
$data["title"]="Create video";
$this->load->view("template",$data);
}
public function createvideosubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("videourl","Video Url","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createvideo";
$data["title"]="Create video";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$videourl=$this->input->get_post("videourl");
$title=$this->input->get_post("title");
if($this->video_model->create($order,$videourl,$title)==0)
$data["alerterror"]="New video could not be created.";
else
$data["alertsuccess"]="video created Successfully.";
$data["redirect"]="site/viewvideo";
$this->load->view("redirect",$data);
}
}
public function editvideo()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editvideo";
$data["title"]="Edit video";
$data["before"]=$this->video_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editvideosubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("videourl","Video Url","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editvideo";
$data["title"]="Edit video";
$data["before"]=$this->video_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$videourl=$this->input->get_post("videourl");
$title=$this->input->get_post("title");
if($this->video_model->edit($id,$order,$videourl,$title)==0)
$data["alerterror"]="New video could not be Updated.";
else
$data["alertsuccess"]="video Updated Successfully.";
$data["redirect"]="site/viewvideo";
$this->load->view("redirect",$data);
}
}
public function deletevideo()
{
$access=array("1");
$this->checkaccess($access);
$this->video_model->delete($this->input->get("id"));
$data["redirect"]="site/viewvideo";
$this->load->view("redirect",$data);
}
public function viewdigitalmarketing()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewdigitalmarketing";
$data["base_url"]=site_url("site/viewdigitalmarketingjson");
$data["title"]="View digitalmarketing";
$this->load->view("template",$data);
}
function viewdigitalmarketingjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_digitalmarketing`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`ting_digitalmarketing`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`ting_digitalmarketing`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`ting_digitalmarketing`.`facebooklink`";
$elements[3]->sort="1";
$elements[3]->header="Facebook Link";
$elements[3]->alias="facebooklink";
$elements[4]=new stdClass();
$elements[4]->field="`ting_digitalmarketing`.`twitterlink`";
$elements[4]->sort="1";
$elements[4]->header="Twitter Link";
$elements[4]->alias="twitterlink";
$elements[5]=new stdClass();
$elements[5]->field="`ting_digitalmarketing`.`googlelink`";
$elements[5]->sort="1";
$elements[5]->header="Google Link";
$elements[5]->alias="googlelink";
$elements[6]=new stdClass();
$elements[6]->field="`ting_digitalmarketing`.`linkedinlink`";
$elements[6]->sort="1";
$elements[6]->header="Linkedin Link";
$elements[6]->alias="linkedinlink";
$elements[7]=new stdClass();
$elements[7]->field="`ting_digitalmarketing`.`instagramlink`";
$elements[7]->sort="1";
$elements[7]->header="Instagram Link";
$elements[7]->alias="instagramlink";
$elements[8]=new stdClass();
$elements[8]->field="`ting_digitalmarketing`.`youtubelink`";
$elements[8]->sort="1";
$elements[8]->header="Youtube Link";
$elements[8]->alias="youtubelink";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_digitalmarketing`");
$this->load->view("json",$data);
}

public function createdigitalmarketing()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createdigitalmarketing";
$data["title"]="Create digitalmarketing";
$this->load->view("template",$data);
}
public function createdigitalmarketingsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("facebooklink","Facebook Link","trim");
$this->form_validation->set_rules("twitterlink","Twitter Link","trim");
$this->form_validation->set_rules("googlelink","Google Link","trim");
$this->form_validation->set_rules("linkedinlink","Linkedin Link","trim");
$this->form_validation->set_rules("instagramlink","Instagram Link","trim");
$this->form_validation->set_rules("youtubelink","Youtube Link","trim");
$this->form_validation->set_rules("pinterestlink","Pinterest Link","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createdigitalmarketing";
$data["title"]="Create digitalmarketing";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$facebooklink=$this->input->get_post("facebooklink");
$twitterlink=$this->input->get_post("twitterlink");
$googlelink=$this->input->get_post("googlelink");
$linkedinlink=$this->input->get_post("linkedinlink");
$instagramlink=$this->input->get_post("instagramlink");
$youtubelink=$this->input->get_post("youtubelink");
$pinterestlink=$this->input->get_post("pinterestlink");
 $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = 'image';
            $image = '';
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
                $config_r['maintain_ratio'] = true;
                $config_t['create_thumb'] = false; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;

                // end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    $data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

                    // return false;
                } else {

                    // print_r($this->image_lib->dest_image);
                    // dest_image

                    $image = $this->image_lib->dest_image;

                    // return false;
                }
            }

if($this->digitalmarketing_model->create($order,$image,$facebooklink,$twitterlink,$googlelink,$linkedinlink,$instagramlink,$youtubelink,$pinterestlink)==0)
$data["alerterror"]="New digitalmarketing could not be created.";
else
$data["alertsuccess"]="digitalmarketing created Successfully.";
$data["redirect"]="site/viewdigitalmarketing";
$this->load->view("redirect",$data);
}
}
public function editdigitalmarketing()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editdigitalmarketing";
$data["title"]="Edit digitalmarketing";
$data["before"]=$this->digitalmarketing_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editdigitalmarketingsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("facebooklink","Facebook Link","trim");
$this->form_validation->set_rules("twitterlink","Twitter Link","trim");
$this->form_validation->set_rules("googlelink","Google Link","trim");
$this->form_validation->set_rules("linkedinlink","Linkedin Link","trim");
$this->form_validation->set_rules("instagramlink","Instagram Link","trim");
$this->form_validation->set_rules("youtubelink","Youtube Link","trim");
$this->form_validation->set_rules("pinterestlink","Pinterest Link","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editdigitalmarketing";
$data["title"]="Edit digitalmarketing";
$data["before"]=$this->digitalmarketing_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$facebooklink=$this->input->get_post("facebooklink");
$twitterlink=$this->input->get_post("twitterlink");
$googlelink=$this->input->get_post("googlelink");
$linkedinlink=$this->input->get_post("linkedinlink");
$instagramlink=$this->input->get_post("instagramlink");
$youtubelink=$this->input->get_post("youtubelink");
$pinterestlink=$this->input->get_post("pinterestlink");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = 'image';
            $image = '';
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
                $config_r['maintain_ratio'] = true;
                $config_t['create_thumb'] = false; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;

                // end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    $data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

                    // return false;
                } else {

                    // print_r($this->image_lib->dest_image);
                    // dest_image

                    $image = $this->image_lib->dest_image;

                    // return false;
                }
            }

            if ($image == '') {
                $image = $this->digitalmarketing_model->getImageById($id);

                // print_r($image);

                $image = $image->image;
            }

if($this->digitalmarketing_model->edit($id,$order,$image,$facebooklink,$twitterlink,$googlelink,$linkedinlink,$instagramlink,$youtubelink,$pinterestlink)==0)
$data["alerterror"]="New digitalmarketing could not be Updated.";
else
$data["alertsuccess"]="digitalmarketing Updated Successfully.";
$data["redirect"]="site/viewdigitalmarketing";
$this->load->view("redirect",$data);
}
}
public function deletedigitalmarketing()
{
$access=array("1");
$this->checkaccess($access);
$this->digitalmarketing_model->delete($this->input->get("id"));
$data["redirect"]="site/viewdigitalmarketing";
$this->load->view("redirect",$data);
}
public function viewapps()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewapps";
$data["base_url"]=site_url("site/viewappsjson");
$data["title"]="View apps";
$this->load->view("template",$data);
}
function viewappsjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_apps`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`ting_apps`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`ting_apps`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_apps`");
$this->load->view("json",$data);
}

public function createapps()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createapps";
$data["title"]="Create apps";
$this->load->view("template",$data);
}
public function createappssubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createapps";
$data["title"]="Create apps";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$title=$this->input->get_post("title");
 $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = 'image';
            $image = '';
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
                $config_r['maintain_ratio'] = true;
                $config_t['create_thumb'] = false; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;

                // end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    $data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

                    // return false;
                } else {

                    // print_r($this->image_lib->dest_image);
                    // dest_image

                    $image = $this->image_lib->dest_image;

                    // return false;
                }
            }

if($this->apps_model->create($order,$image,$title)==0)
$data["alerterror"]="New apps could not be created.";
else
$data["alertsuccess"]="apps created Successfully.";
$data["redirect"]="site/viewapps";
$this->load->view("redirect",$data);
}
}
public function editapps()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editapps";
$data["title"]="Edit apps";
$data["before"]=$this->apps_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editappssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editapps";
$data["title"]="Edit apps";
$data["before"]=$this->apps_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$title=$this->input->get_post("title");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = 'image';
            $image = '';
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
                $config_r['maintain_ratio'] = true;
                $config_t['create_thumb'] = false; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;

                // end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    $data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

                    // return false;
                } else {

                    // print_r($this->image_lib->dest_image);
                    // dest_image

                    $image = $this->image_lib->dest_image;

                    // return false;
                }
            }

            if ($image == '') {
                $image = $this->apps_model->getImageById($id);

                // print_r($image);

                $image = $image->image;
            }

if($this->apps_model->edit($id,$order,$image,$title)==0)
$data["alerterror"]="New apps could not be Updated.";
else
$data["alertsuccess"]="apps Updated Successfully.";
$data["redirect"]="site/viewapps";
$this->load->view("redirect",$data);
}
}
public function deleteapps()
{
$access=array("1");
$this->checkaccess($access);
$this->apps_model->delete($this->input->get("id"));
$data["redirect"]="site/viewapps";
$this->load->view("redirect",$data);
}
public function viewwebsite()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewwebsite";
$data["base_url"]=site_url("site/viewwebsitejson");
$data["title"]="View website";
$this->load->view("template",$data);
}
function viewwebsitejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`ting_website`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`ting_website`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`ting_website`.`type`";
$elements[2]->sort="1";
$elements[2]->header="Type";
$elements[2]->alias="type";
$elements[3]=new stdClass();
$elements[3]->field="`ting_website`.`image`";
$elements[3]->sort="1";
$elements[3]->header="Image";
$elements[3]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `ting_website`");
$this->load->view("json",$data);
}

public function createwebsite()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createwebsite";
$data['type'] = $this->user_model->getTypeDropDown();
$data["title"]="Create website";
$this->load->view("template",$data);
}
public function createwebsitesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createwebsite";
$data['type'] = $this->user_model->getTypeDropDown();
$data["title"]="Create website";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$type=$this->input->get_post("type");
$title=$this->input->get_post("title");
 $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = 'image';
            $image = '';
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
                $config_r['maintain_ratio'] = true;
                $config_t['create_thumb'] = false; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;

                // end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    $data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

                    // return false;
                } else {

                    // print_r($this->image_lib->dest_image);
                    // dest_image

                    $image = $this->image_lib->dest_image;

                    // return false;
                }
            }

if($this->website_model->create($order,$type,$image,$title)==0)
$data["alerterror"]="New website could not be created.";
else
$data["alertsuccess"]="website created Successfully.";
$data["redirect"]="site/viewwebsite";
$this->load->view("redirect",$data);
}
}
public function editwebsite()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editwebsite";
$data["title"]="Edit website";
$data['type'] = $this->user_model->getTypeDropDown();
$data["before"]=$this->website_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editwebsitesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editwebsite";
$data['type'] = $this->user_model->getTypeDropDown();
$data["title"]="Edit website";
$data["before"]=$this->website_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$type=$this->input->get_post("type");
$title=$this->input->get_post("title");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = 'image';
            $image = '';
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
                $config_r['maintain_ratio'] = true;
                $config_t['create_thumb'] = false; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;

                // end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    $data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

                    // return false;
                } else {

                    // print_r($this->image_lib->dest_image);
                    // dest_image

                    $image = $this->image_lib->dest_image;

                    // return false;
                }
            }

            if ($image == '') {
                $image = $this->website_model->getImageById($id);

                // print_r($image);

                $image = $image->image;
            }

if($this->website_model->edit($id,$order,$type,$image,$title)==0)
$data["alerterror"]="New website could not be Updated.";
else
$data["alertsuccess"]="website Updated Successfully.";
$data["redirect"]="site/viewwebsite";
$this->load->view("redirect",$data);
}
}
public function deletewebsite()
{
$access=array("1");
$this->checkaccess($access);
$this->website_model->delete($this->input->get("id"));
$data["redirect"]="site/viewwebsite";
$this->load->view("redirect",$data);
}

}
?>

<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Edit digitalmarketing</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editdigitalmarketingsubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order',$before->order);?>'>
</div>
</div>
<input type="file" id="normal-field" class="form-control" name="image" value='<?php echo set_value('image',$before->image);?>'>
<div class="row">
			<div class="file-field input-field col m6 s12">
				<span class="img-center big image1">
                   			<?php if ($before->image == '') {
} else {
    ?><img src="<?php echo base_url('uploads').'/'.$before->image;
    ?>">
						<?php
} ?></span>
				<div class="btn blue darken-4">
					<span>Image</span>
					<input name="image" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate image1" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image', $before->image);?>">
				</div>
			
			</div>

		</div>
<div class="row">
<div class="input-field col s6">
<label for="Facebook Link">Facebook Link</label>
<input type="text" id="Facebook Link" name="facebooklink" value='<?php echo set_value('facebooklink',$before->facebooklink);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Twitter Link">Twitter Link</label>
<input type="text" id="Twitter Link" name="twitterlink" value='<?php echo set_value('twitterlink',$before->twitterlink);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Google Link">Google Link</label>
<input type="text" id="Google Link" name="googlelink" value='<?php echo set_value('googlelink',$before->googlelink);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Linkedin Link">Linkedin Link</label>
<input type="text" id="Linkedin Link" name="linkedinlink" value='<?php echo set_value('linkedinlink',$before->linkedinlink);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Instagram Link">Instagram Link</label>
<input type="text" id="Instagram Link" name="instagramlink" value='<?php echo set_value('instagramlink',$before->instagramlink);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Youtube Link">Youtube Link</label>
<input type="text" id="Youtube Link" name="youtubelink" value='<?php echo set_value('youtubelink',$before->youtubelink);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Pinterest Link">Pinterest Link</label>
<input type="text" id="Pinterest Link" name="pinterestlink" value='<?php echo set_value('pinterestlink',$before->pinterestlink);?>'>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewdigitalmarketing"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>

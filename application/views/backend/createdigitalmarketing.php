<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Create digitalmarketing</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createdigitalmarketingsubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order');?>'>
</div>
</div>
<div class="row">
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Image</span>
<input type="file" name="image">
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('image');?>'>
</div>
</div>
<span style="line-height: 600%;color:#B5ACAC">Size of Image should be between 250px and 150px.</span>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Facebook Link">Facebook Link</label>
<input type="text" id="Facebook Link" name="facebooklink" value='<?php echo set_value('facebooklink');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Twitter Link">Twitter Link</label>
<input type="text" id="Twitter Link" name="twitterlink" value='<?php echo set_value('twitterlink');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Google Link">Google Link</label>
<input type="text" id="Google Link" name="googlelink" value='<?php echo set_value('googlelink');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Linkedin Link">Linkedin Link</label>
<input type="text" id="Linkedin Link" name="linkedinlink" value='<?php echo set_value('linkedinlink');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Instagram Link">Instagram Link</label>
<input type="text" id="Instagram Link" name="instagramlink" value='<?php echo set_value('instagramlink');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Youtube Link">Youtube Link</label>
<input type="text" id="Youtube Link" name="youtubelink" value='<?php echo set_value('youtubelink');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Pinterest Link">Pinterest Link</label>
<input type="text" id="Pinterest Link" name="pinterestlink" value='<?php echo set_value('pinterestlink');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewdigitalmarketing"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>

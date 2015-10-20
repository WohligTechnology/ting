<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Create website</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createwebsitesubmit");?>'  >
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order');?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<label>Type</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
 <input type="checkbox" name="type[]" value="1" id="static"  />
      <label for="static">Static</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
 <input type="checkbox" name="type[]" value="2" id="ecom"  />
      <label for="ecom">Ecom</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
 <input type="checkbox" name="type[]" value="3" id="cms" />
      <label for="cms">Cms</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
  <input type="checkbox" name="type[]" value="4" id="portal"  />
      <label for="portal">Portal</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
 <input type="checkbox" name="type[]" value="5" id="responsive" />
      <label for="responsive">Responsive</label>
 
</div>
</div>

<div class="row">
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Image</span>
<input type="file" name="image" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('image');?>'>
</div>
</div>
<span style="line-height: 600%;color:#B5ACAC">Size of Image should be between 350px and 210px.</span>
</div>

<div class="row">
<div class="input-field col s6">
<label for="Title">Title</label>
<input type="text" id="Title" name="title" value='<?php echo set_value('title');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewwebsite"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>

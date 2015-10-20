<div class="row">
    <div class="col s12">
        <h4 class="pad-left-15">Edit website</h4>
    </div>
</div>
<div class="row">
    <form class='col s12' method='post' action='<?php echo site_url("site/editwebsitesubmit");?>' enctype='multipart/form-data'>
        <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
        <div class="row">
            <div class="input-field col s6">
                <label for="Order">Order</label>
                <input type="text" id="Order" name="order" value='<?php echo set_value(' order ',$before->order);?>'>
            </div>
        </div>
        <div class=" row">
            <div class=" input-field col s6">
                <label>Type</label>
            </div>
        </div>

        <div class=" row">
            <div class=" input-field col s6">
                <?php $data = array(
                    'name'        => 'type[]',
                    'id'          => 'static',
                    'value'       => '1',
                    'checked'     => in_array("1",$gettypes),
                    );
                    echo form_checkbox($data);
                ?>
                <label for="static">Static</label>
            </div>
        </div>
           <div class=" row">
            <div class=" input-field col s6">
                <?php $data = array(
                    'name'        => 'type[]',
                    'id'          => 'ecom',
                    'value'       => '2',
                    'checked'     => in_array("2",$gettypes),
                    );
                    echo form_checkbox($data);
                ?>
                <label for="ecom">Ecom</label>
            </div>
        </div>  
           <div class=" row">
            <div class=" input-field col s6">
                <?php $data = array(
                    'name'        => 'type[]',
                    'id'          => 'cms',
                    'value'       => '3',
                    'checked'     => in_array("3",$gettypes),
                    );
                    echo form_checkbox($data);
                ?>
                <label for="cms">Cms</label>
            </div>
        </div>
           <div class=" row">
            <div class=" input-field col s6">
                <?php $data = array(
                    'name'        => 'type[]',
                    'id'          => 'portal',
                    'value'       => '4',
                    'checked'     => in_array("4",$gettypes),
                    );
                    echo form_checkbox($data);
                ?>
                <label for="portal">Portal</label>
            </div>
        </div>
            <div class=" row">
            <div class=" input-field col s6">
                <?php $data = array(
                    'name'        => 'type[]',
                    'id'          => 'responsive',
                    'value'       => '5',
                    'checked'     => in_array("5",$gettypes),
                    );
                    echo form_checkbox($data);
                ?>
                <label for="responsive">Responsive</label>
            </div>
        </div>

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
                <label for="Title">Title</label>
                <input type="text" id="Title" name="title" value='<?php echo set_value(' title ',$before->title);?>'>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
                <a href='<?php echo site_url("site/viewwebsite"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
            </div>
        </div>
    </form>
</div>
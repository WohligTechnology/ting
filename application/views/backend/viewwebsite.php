<div class="row">
<div class="col s12">
<div class="row">
<div class="col s12 drawchintantable">
<?php $this->chintantable->createsearch(" List of Website");?>
<table class="highlight responsive-table">
<thead>
<tr>
<th data-field="id">ID</th>
<th data-field="title">Title</th>
<th data-field="image">Image</th>
<th data-field="type">Type</th>
<th data-field="order">Order</th>

</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
<?php $this->chintantable->createpagination();?>
<div class="createbuttonplacement"><a class="btn-floating btn-large waves-effect waves-light blue darken-4 tooltipped" href="<?php echo site_url("site/createwebsite"); ?>"data-position="top" data-delay="50" data-tooltip="Create"><i class="material-icons">add</i></a></div>
</div>
</div>
<script>
function drawtable(resultrow) {
	if(resultrow.type==1){
		resultrow.type="Static";
	}
	else if(resultrow.type==2){
		resultrow.type="Ecom";
	}
	else if(resultrow.type==3){
		resultrow.type="CMS";
	}
	else if(resultrow.type==4){
		resultrow.type="Portal";
	}
	else if(resultrow.type==5){
		resultrow.type="Responsive";
	}
	var image = "<a class='img-center' href='<?php echo base_url('uploads').'/'; ?>" + resultrow.image + "' ><img src='<?php echo base_url('uploads').'/'; ?>" + resultrow.image + "' ></a>";
            if (resultrow.image == "") {
                image = "No Receipt Available";
            }
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.title + "</td><td>" + image + "</td><td>" + resultrow.type + "</td><td>" + resultrow.order + "</td><td><a class='btn btn-primary btn-xs waves-effect waves-light blue darken-4 z-depth-0 less-pad' href='<?php echo site_url('site/editwebsite?id=');?>"+resultrow.id+"'><i class='fa fa-pencil propericon'></i></a><a class='btn btn-danger btn-xs waves-effect waves-light red pad10 z-depth-0 less-pad' onclick=return confirm(\"Are you sure you want to delete?\") href='<?php echo site_url('site/deletewebsite?id='); ?>"+resultrow.id+"'><i class='material-icons propericon'>delete</i></a></td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>

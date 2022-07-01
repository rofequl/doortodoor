<div class="x_content">
	<div class="form-group">
		<label class="control-label">Blog title</label>
		
			<input type="text" class="form-control" placeholder="Title" name="title">
		
	</div>

	<div class="form-group">
		<label class="control-label">Blog description</label>
		<textarea class="form-control" rows="10" name="description"></textarea>
	</div>

	<div class="form-group">
		<div class="row">
			<?php $categories = \DB::table('blog_categories')->get(); ?>
			<div class="col-md-6">
				<label class="control-label">Blog Category</label>
				<select class="form-control" name="blog_category_id" required="">
					<option value="">Choose one</option>
					@foreach($categories as $cat)
					<option value="{{$cat->id}}">{{$cat->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-6">
				<label class="text-right control-label">Blog Visibility &nbsp; &nbsp; </label><br>
				<div class="form-check form-check-inline pull-left">
				  <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" checked="">
				  <label class="form-check-label" for="inlineRadio1"> Pushlish Now &nbsp; &nbsp;</label>
				</div>
				<div class="form-check form-check-inline pull-left">
				  <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
				  <label class="form-check-label" for="inlineRadio2"> Pushlish later</label>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="form-group row">
		<div class="col-md-6 col-sm-6">
			<label class="control-label">Blog photo (optional)</label>
			<input type="file" onchange="PreviewImage();" id="uploadImage" class="form-control" name="photo">
		</div>
		<div class="col-md-3"><img id="uploadPreview" src="" style="height:78px" class="photo"></div>
	</div>

</div>

<script type="text/javascript">
	function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
</script>
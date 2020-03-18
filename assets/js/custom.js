$(document).ready(function () {
	$(".select2").select2();
	bsCustomFileInput.init();
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			console.log("image uploaded");
			$('.custom-file').after('<div class="col col-xl-2 col-lg-3 col-md-6" id="uploadedImage"></div>');
			$('#uploadedImage').append(document.createElement("img"));
			$('img').attr('src', e.target.result).attr('width', '100%');
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("#menu_image").change(function () {
	readURL(this);
});

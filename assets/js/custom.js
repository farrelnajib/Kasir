$(document).ready(function () {
	$(".select2").select2({
		theme: 'bootstrap4',
		placeholder: $(this).attr('placeholder')
	});
	bsCustomFileInput.init();
	$(".dataTable").DataTable();
	$(".menuDataTable").DataTable({
		"order": [
			[0, "desc"]
		]
	});

	$('#price').number(true);
	$('#final-price').number(true);
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


$('#search-bar').keyup(function () {
	var query = $(this).val().toLowerCase();
	$(".card .card-body .text-menu").each(function () {
		var text = $(this).text().toLowerCase();
		if (text.indexOf(query) != -1) {
			$(this).parent().parent().parent().parent().show();
		} else {
			$(this).parent().parent().parent().parent().hide();
		}
	});
});


$('#discount').keyup(function () {
	let disc = $(this).val();

	if (!disc || Number(disc) < 0) {
		$(this).val(0);
	} else {
		disc = Number(disc);

		if (disc > 100) {
			disc = 100;
		}
		$(this).val(disc);
	}

	let harga_akhir = $('#price').val() * ((100 - disc) / 100);
	$('#final-price').val(harga_akhir);
});


$('#price').keyup(function () {
	let harga = $(this).val();
	console.log(harga);
	let diskon = $('#discount').val();
	let harga_akhir = harga * ((100 - diskon) / 100);

	$('#final-price').val(harga_akhir);

});


$('#final-price').keyup(function () {
	let price = Number($('#price').val());
	let final_price = $(this).val();

	if (!final_price) {
		$(this).val(0);
	} else {
		final_price = Number(final_price);
		$(this).val(final_price);
	}

	if (final_price > price) {
		final_price = price;
		$(this).val(final_price);
	}

	let discount = 100 - (final_price / price * 100);
	$('#discount').val(discount);
});

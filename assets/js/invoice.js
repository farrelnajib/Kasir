let transactionID;

function showInvoice(transaction_id) {
	$('#invoiceModal').modal('show');
	let modalBody = $('.modal-body');

	modalBody.html(`
		<div class="d-flex justify-content-center">
			<div class="spinner-grow text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	`);

	$.ajax({
		type: 'GET',
		url: APP_URL + 'admin/dashboard/invoice/' + transaction_id,
		dataType: 'JSON',
		success: (response) => {
			transactionID = transaction_id;

			let email = response.transaction.customer_phone;
			if (email == '') {
				email = response.transaction.customer_email;
			}

			let ordersRow = ``;
			response.orders.forEach(order => {
				ordersRow += `
				<tr class="details">
					<td>` + order.menu_name + `</td>
					<td>Rp. ` + Number(order.menu_final_price).toLocaleString('en-US', {}) + `</td>
					<td class="jumlah">` + order.order_quantity + `</td>
					<td>Rp. ` + Number(order.order_subtotal).toLocaleString('en-US', {}) + `</td>
				</tr>
				`;
			});

			let paymentsRow = ``;
			response.payments.forEach(payment => {
				paymentsRow += `
				<tr class="item">
					<td>Pembayaran: ` + payment.method_name + `</td>
					<td></td>
					<td></td>
					<td>Rp. ` + Number(payment.payment_amount).toLocaleString('en-US') + `</td>
				</tr>
				`;
			});


			modalBody.html(
				`<div class="invoice-box">
					<table cellpadding="0" cellspacing="0">
						<tr class="top">
							<td colspan="4">
								<table>
									<td class="title">
										<center>
											Waroenk Abnormal
										</center>
									</td>
						
									<tr>
										<td>
											Invoice : ` + response.transaction.transaction_id + ` <br>
											Open bill: ` + response.transaction.transaction_open_bill + `<br>
											Close bill: ` + response.transaction.transaction_close_bill + `<br>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					
						<tr class="information">
							<td colspan="4">
							<table>
								<tr>
								<td>
									Jalan Pasir Kaliki No.25-27 <br>
									Kebon Jeruk, Andir, Bandung, 40181 <br>
									(022) 20568888
								</td>
					
								<td style="text-align: right">
									Customer: <br>
									` + response.transaction.customer_name + `<br>
									` + email + `
								</td>
								</tr>
							</table>
							</td>
						</tr>
					
						<tr class="heading">
							<td>Item</td>
							<td>Harga</td>
							<td class="jumlah">Jumlah</td>
							<td>Subtotal</td>
						</tr>
					
						` + ordersRow + `
					
						<tr class="heading">
							<td>Totals</td>
							<td></td>
							<td></td>
							<td>Jumlah</td>
						</tr>
					
						<tr class="item">
							<td>Subtotal</td>
							<td></td>
							<td></td>
							<td>Rp. ` + Number(response.transaction.transaction_subtotal).toLocaleString('en-US') + `</td>
						</tr>
					
						<tr class="item">
							<td>Tax</td>
							<td></td>
							<td></td>
							<td>Rp. ` + Number(response.transaction.transaction_tax).toLocaleString('en-US') + `</td>
						</tr>
					
						<tr class="item">
							<td>Total</td>
							<td></td>
							<td></td>
							<td>Rp. ` + Number(response.transaction.transaction_total).toLocaleString('en-US') + `</td>
						</tr>
					
						<tr class="heading">
							<td>Pembayaran</td>
							<td></td>
							<td></td>
							<td>Jumlah</td>
						</tr>
					
						` + paymentsRow + `
					
						<tr class="item">
							<td>Total pembayaran</td>
							<td></td>
							<td></td>
							<td>Rp. ` + Number(response.transaction.transaction_payment).toLocaleString('en-US') + `</td>
						</tr>
					
						<tr class="total">
							<td>Kembalian</td>
							<td></td>
							<td></td>
							<td>Rp. ` + Number(response.transaction.transaction_change).toLocaleString('en-US') + `</td>
						</tr>
					</table>
				</div>`
			);
		}
	});
}


$('.modal').on('click', '#resend', () => {
	let button = document.getElementById('resend');
	button.classList.add('disabled');
	button.setAttribute('disabled', true);
	button.innerHTML = `<i class="fa fa-circle-notch fa-spin"></i>`;
	$.ajax({
		type: 'GET',
		url: APP_URL + 'transaction/invoice/' + transactionID,
		dataType: 'JSON',
		data: {
			'method': 'resend'
		}
	}).done((response) => {
		console.log(response);
		let keteranganAlert,
			warnaAlert;

		if (response.status) {
			keteranganAlert = "Success resend invoice";
			warnaAlert = "success";
		} else {
			keteranganAlert = "Failed to resend invoice";
			warnaAlert = "danger";
		}

		$('#invoiceModal').modal('hide');
		button.removeAttribute('disabled');
		button.classList.remove('disabled');
		button.innerHTML = 'Resend invoice';

		document.getElementById('alert').innerHTML = `
			<div class="alert alert-` + warnaAlert + ` alert-dismissible fade show" role="alert">
				` + keteranganAlert + `
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		`;
	});
});

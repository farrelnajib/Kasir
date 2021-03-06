<?php
$email = $transaction->customer_email;
if (empty($transaction->customer_email)) {
	$email = $transaction->customer_phone;
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<style>
		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
		}

		.invoice-box table {
			width: 100%;
			line-height: inherit;
		}

		.invoice-box table td {
			padding: 5px;
			vertical-align: top;
		}

		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}

		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #ddd;
			font-weight: bold;
		}

		.invoice-box table tr.item td {
			border-bottom: 1px solid #eee;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(4) {
			border-top: 2px solid #eee;
			font-weight: bold;
		}

		td:nth-child(4) {
			text-align: right;
		}

		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}

			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}

		/** RTL **/
		.rtl {
			direction: rtl;
			font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		}

		.rtl table {
			text-align: right;
		}

		.rtl table tr td:nth-child(2) {
			text-align: left;
		}

		.jumlah {
			text-align: center
		}
	</style>
</head>

<body>
	<div class="invoice-box">
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
								Invoice : <?= $transaction->transaction_id; ?> <br>
								Open bill: <?= $transaction->transaction_open_bill; ?><br>
								Close bill: <?= $transaction->transaction_close_bill; ?><br>
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
								<?= $transaction->customer_name; ?><br>
								<?= $email; ?>
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

			<?php foreach ($orders as $order) : ?>
				<tr class="details">
					<td><?= $order->menu_name; ?></td>
					<td>Rp. <?= number_format($order->menu_final_price); ?></td>
					<td class="jumlah"><?= $order->order_quantity; ?></td>
					<td>Rp. <?= number_format($order->order_subtotal); ?></td>
				</tr>
			<?php endforeach; ?>

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
				<td>Rp. <?= number_format($transaction->transaction_subtotal); ?></td>
			</tr>

			<tr class="item">
				<td>Tax</td>
				<td></td>
				<td></td>
				<td>Rp. <?= number_format($transaction->transaction_tax); ?></td>
			</tr>

			<tr class="item">
				<td>Total</td>
				<td></td>
				<td></td>
				<td>Rp. <?= number_format($transaction->transaction_total); ?></td>
			</tr>

			<tr class="heading">
				<td>Pembayaran</td>
				<td></td>
				<td></td>
				<td>Jumlah</td>
			</tr>

			<?php foreach ($payments as $payment) : ?>
				<tr class="item">
					<td>Pembayaran: <?= $payment->method_name; ?></td>
					<td></td>
					<td></td>
					<td>Rp. <?= number_format($payment->payment_amount); ?></td>
				</tr>
			<?php endforeach; ?>

			<tr class="item">
				<td>Total pembayaran</td>
				<td></td>
				<td></td>
				<td>Rp. <?= number_format($transaction->transaction_payment); ?></td>
			</tr>

			<tr class="total">
				<td>Kembalian</td>
				<td></td>
				<td></td>
				<td>Rp. <?= number_format($transaction->transaction_change); ?></td>
			</tr>
		</table>
	</div>
</body>

</html>

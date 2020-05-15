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
  <link rel="stylesheet" href="<?= base_url('assets/css/invoice.css'); ?>">
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
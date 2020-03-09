<!-- Breadcrumbs-->
<ol class="breadcrumb border-left-primary mb-4 shadow" style="background-color: white;">
  <?php $jumlah = 0; ?>
  <?php foreach ($this->uri->segments as $segment) : ?>
    <?php
    $jumlah++;
    if ($jumlah > 3) break;
    $url = substr($this->uri->uri_string, 0, strpos($this->uri->uri_string, $segment)) . $segment;
    $is_active =  $url == $this->uri->uri_string;
    ?>


    <li class="breadcrumb-item <?php echo $is_active || $jumlah > 2 ? 'active' : '' ?>">
      <?php if ($is_active || $jumlah > 2) : ?>
        <?php echo ucfirst($segment) ?>
      <?php else : ?>
        <a href="<?php echo base_url($url) ?>"><?php echo ucfirst($segment) ?></a>
      <?php endif; ?>
    </li>

  <?php endforeach; ?>
</ol>
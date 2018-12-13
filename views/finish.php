<h1>Import Tracking Codes for Woocommerce Correios</h1>

<hr>
<p>Total of lines: <?php echo count($lines); ?></p>
<p>Orders processed: <?php echo $ordersProcessing; ?></p>
<p>Orders not found: (<?php echo count($notOrders) . ") - " . implode(', ',$notOrders); ?></p>
<p>Orders already with code: (<?php echo  count($ordersWithCode) . ") - " . implode(', ',$ordersWithCode); ?></p>
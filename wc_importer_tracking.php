<?php
/**
 * Plugin Name:     Tracking Code Importer for Woocommerce Correios
 * Plugin URI:      http://asaferamos.com
 * Description:     Tracking Code Importer for Woocommerce Correios
 * Author:          Asafe Ramos
 * Author URI:      http://asaferamos.com
 * Text Domain:     woocommerce-correios-importer-tracking
 * Version:         0.1.0
 *
 * @package         Woocommerce_Importer_Tracking
 */

class WC_Importer_Tracking{
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_menu() {
		$page = add_submenu_page(
            'woocommerce',
            __('Tracking Code Importer', 'wc_importer_tracking'),
            __('Tracking Code Importer', 'wc_importer_tracking'),
            apply_filters('woocommerce_csv_order_role', 'manage_woocommerce'),
            'wc_importer_tracking',
            array($this, 'output')
        );
	}

	public function output() {
        if(isset($_POST['tracking_codes'])){
            self::import();
        }else{
            include 'views/import.php';
        }
    }
    
    public function import(){
        $lines = explode("\n", $_POST['tracking_codes']);

        $notOrders        = [];
        $ordersWithCode   = [];
        $ordersProcessing = 0;

        foreach($lines as $line){
            $line     = explode("\t",$line);

            $order_id = $line[0];
            $code     = $line[1];

            if($order = wc_get_order( $order_id )){
                if(empty($order->get_meta('_correios_tracking_code'))){
                    wc_correios_update_tracking_code($order_id,$code);
                    $ordersProcessing++;
                }else{
                    $ordersWithCode[] = $order_id;
                }
            }else{
                $notOrders[] = $order_id;
            }
        }

        include 'views/finish.php';
    }
}

new WC_Importer_Tracking();
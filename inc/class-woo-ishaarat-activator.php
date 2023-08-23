<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-activator.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat_Activator {
	/**
	 * @return void
	 */
	public static function activate() {
		$saved_version = get_site_option("WOO_ISHAARAT_PLUGIN_VERSION");
		if (version_compare($saved_version, WOO_ISHAARAT_VERSION, '<') && self::upgrade()) {
			add_option('WOO_ISHAARAT_PLUGIN_VERSION', WOO_ISHAARAT_VERSION);
		}
		if(!$saved_version){
			self::upgrade();
			add_option('WOO_ISHAARAT_PLUGIN_VERSION', WOO_ISHAARAT_VERSION);
		}
	}

	/**
	 * @return bool
	 */
	private static function upgrade() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		// messages log table
		$table_name = $wpdb->base_prefix . '_ishaarat_logs';
		$sql    = "CREATE TABLE `{$table_name}` (
						`log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`msg_to` varchar(255) NOT NULL DEFAULT '0',
						`messages` text,
						`status` varchar(7) NOT NULL DEFAULT 'pending',
  						`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  						PRIMARY KEY (log_id)  						
                     ) $charset_collate;";

		//subscribers table
		$table_name = $wpdb->base_prefix . '_ishaarat_subscribers';
		$sql    .= "CREATE TABLE `{$table_name}` (
						`subscriber_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`customer_id` mediumint(255) NOT NULL,
						`customer_consent` varchar(255) NULL DEFAULT 'off',
						`registered_page` varchar(255) NULL ,
						`order_id` varchar(255) NULL,
  						`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  						PRIMARY KEY (subscriber_id)  						
                     ) $charset_collate;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		return empty($wpdb->last_error);
	}
}
<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-ishaarat-admin-subscribers.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
class Woo_Ishaarat_Admin_Logs extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => __( 'Log', WOO_ISHAARAT_PLUGIN_NAME ), // singular name of the listed records
				'plural'   => __( 'Logs', WOO_ISHAARAT_PLUGIN_NAME ), // plural name of the listed records
				'ajax'     => false, // does this table support ajax?
			)
		);

		add_action(
			'admin_enqueue_scripts',
			function() {
				wp_enqueue_script( 'fontawesome', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.0/js/fontawesome.min.js', array(), uniqid(), true );
			}
		);

	}


	/**
	 * Check if subscribers table exist or not.
	 */
	public static function check_if_table_exists() {
		global $wpdb;
		$table_name      = $wpdb->prefix . '_ishaarat_logs';
		$sql = "SHOW TABLES LIKE '{$table_name}'";
		$query = $wpdb->get_results( $sql, 'ARRAY_A' );
		if ( ! function_exists('dbDelta') ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}
		if ( count( $query ) < 1 ) {
			$charset_collate = $wpdb->get_charset_collate();
			$sql    = "CREATE TABLE `{$table_name}` (
						`log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`msg_to` varchar(255) NOT NULL DEFAULT '0',
						`messages` text,
						`status` varchar(7) NOT NULL DEFAULT 'pending',
  						`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  						PRIMARY KEY (log_id)  						
                     ) $charset_collate;";
			dbDelta( $sql );
			add_option('WOO_ISHAARAT_PLUGIN_VERSION', WOO_ISHAARAT_VERSION);
		}
	}


	/**
	 * Retrieve customers data from the database.
	 *
	 * @param mixed $per_page
	 * @param mixed $page_number
	 * @param mixed $pagination_args
	 *
	 * @return array|object|stdClass[]|null
	 */
	public static function get_logs( $per_page = 5, $page_number = 1, $pagination_args = false ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}_ishaarat_logs";

		if ( $pagination_args ) {
			$sql .= ' ORDER BY created_at DESC';
		}
		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
		return $wpdb->get_results( $sql, 'ARRAY_A' );
	}
	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_log( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}_ishaarat_logs",
			array( 'ID' => $id ),
			array( '%d' )
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}_ishaarat_logs";

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no customer data is available */
	public function no_items() {
		esc_html_e( 'No logs available.', WOO_ISHAARAT_PLUGIN_NAME );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array  $item
	 * @param string $column_name
     * @return void
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'created_at':
				echo wp_date( 'm/d/Y H:i:s', strtotime( $item['created_at'] ) );
				break;
			default:
                if(is_array($item[$column_name]))
                    print_r( $item[$column_name], true );
                else
	                echo esc_attr( ucfirst( $item[$column_name] ) );
				break;
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />',
			$item['log_id']
		);
	}


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name( $item ) {

		$delete_nonce = wp_create_nonce( 'woo_ishaarat_log_delete_nonce' );

		$title = '<strong>' . $item['name'] . '</strong>';

		$actions = array(
			'delete' => sprintf( '<a href="?page=%s&action=%s&log_ids=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce ),
		);

		return $title . $this->row_actions( $actions );
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = array(
			'cb'                       => '<input type="checkbox" />',
			'msg_to' => __( 'Phone Number', WOO_ISHAARAT_PLUGIN_NAME ),
			'messages'         => __( 'Message', WOO_ISHAARAT_PLUGIN_NAME ),
			'status'            => __( 'Status', WOO_ISHAARAT_PLUGIN_NAME ),
			'created_at'                     => __( 'Date', WOO_ISHAARAT_PLUGIN_NAME ),
		);

		return $columns;
	}


	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'bulk-delete' => 'Delete',
		);

		return $actions;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		self::check_if_table_exists();

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'logs_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args(
			array(
				'total_items' => $total_items, // WE have to calculate the total number of items.
				'per_page'    => $per_page, // WE have to determine how many items to show on a page.
			)
		);

		$this->items = self::get_logs( $per_page, $current_page, true );
	}

	public function process_bulk_action() {

		// Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'woo_ishaarat_log_delete_nonce' ) ) {
				die( 'Go get a life script kiddies' );
			} else {
				if ( isset( $_GET['log_ids'] ) ) {
					self::delete_log( absint( $_GET['log_ids'] ) );
					wp_safe_redirect( esc_url_raw( add_query_arg() ) );
					exit;
				}
			}
		}

		// If the delete bulk action is triggered.
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = filter_input_array( INPUT_POST );
			// loop over the array of record IDs and delete them.
			foreach ( $delete_ids['bulk-delete'] as $id ) {
				self::delete_log( $id );

			}
			wp_safe_redirect( esc_url_raw( add_query_arg() ) );
			exit;
		}
	}
}

class Woo_Ishaarat_Admin_Logs_Loader {

	// class instance.
	static $instance;

	// customer WP_List_Table object.
	public $logs_obj;

	// class constructor.
	public function __construct() {
		add_filter( 'set-screen-option', array( __CLASS__, 'set_screen' ), 10, 3 );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}


	/**
	 * Plugin settings page
	 */
	public function plugin_settings_page() {
		?>
		<div class="wrap">
			<h2>Logs</h2>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post" class="wooishaarat-custom-tables">
								<?php
								$this->logs_obj->prepare_items();
								$this->logs_obj->display();
								?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
		<?php
	}

	/**
	 * Screen options
	 */
	public function screen_option() {

		$option = 'per_page';
		$args   = array(
			'label'   => 'Logs',
			'default' => 7,
			'option'  => 'logs_per_page',
		);

		add_screen_option( $option, $args );

		$this->logs_obj = new Woo_Ishaarat_Admin_Logs();
	}


	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}


add_action(
	'plugins_loaded',
	function () {
		Woo_Ishaarat_Admin_Logs_Loader::get_instance();
	}
);
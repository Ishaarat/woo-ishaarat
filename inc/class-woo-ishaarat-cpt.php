<?php

/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-cpt.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat_CPT
{
    /**
     * create customer list cutom post type
     *
     * @return void
     */
    public static function init()
    {
        register_post_type(
            'ishaarat_cl',
            array(
                'labels' => array(
                    'name' => __('Customer Lists', WOO_ISHAARAT_PLUGIN_NAME),
                    'singular_name' => __('Customer List', WOO_ISHAARAT_PLUGIN_NAME),
                    'add_new' => __('New Customer List', WOO_ISHAARAT_PLUGIN_NAME),
                    'add_new_item' => __('New Customer List', WOO_ISHAARAT_PLUGIN_NAME),
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array('title'),
                'show_in_admin_bar' => false,
                'show_in_nav_menus' => false,
                'show_in_menu' => false,
            )
        );
    }

    /**
     * This function add metabox in other to use it with the plugin.
     *
     * @return void
     */
    public static function add_metabox()
    {
        add_meta_box(
            'ishaarat_cl_metabox',
            __('Contact List Details', WOO_ISHAARAT_PLUGIN_NAME),
            array(__CLASS__, 'render_metabox'),
            'ishaarat_cl',
            'normal',
            'high'
        );
    }

    public static function render_metabox($post)
    {
        $customer_list_data = get_post_meta($post->ID, 'woo-ishaarat-cl') ?? [];
        if(!empty($customer_list_data))
            $customer_list_data = $customer_list_data[0];
        $filters = array_filter($customer_list_data, function ($item) {
            return isset($item['cl-rules']) && isset($item['cl-options']);
        });
        ?>
        <div class="inside">
            <script>
                var woo_ishaarat_cl_type = "<?=  $customer_list_data["customer-list-search-type"] ?? "by-id"; ?>";
                var woo_ishaarat_csv_data = [];
                woo_ishaarat_ajax_object.cl_list_data = <?= json_encode(array_values($filters)) ?>;
            </script>
            <table style="border-style:double" name="homescript-input-contact-list-builder">
                <tbody>
                <tr class="woo-ishaarat-customer-list-label">
                    <td class="woo-ishaarat-table-label">
                        <strong>Extraction mode</strong>
                        <br>How would you want to retrieve Phone Numbers for the Contact List?
                    </td>
                    <td>
							<span class="homescript-input-wrapper">
								<div class="woo-ishaarat-radio">
									<span>
										<input type="radio" class="input-radio " value="by-id"
                                               name="woo-ishaarat-cl[customer-list-search-type]"
                                               id="woo-ishaarat-cl[customer-list-search-type]_by-id"
                                                <?= (isset($customer_list_data['customer-list-search-type']) && $customer_list_data['customer-list-search-type'] == 'by-id') ? 'checked="checked"' : '';?> ><label
                                                for="woo-ishaarat-cl[customer-list-search-type]_by-id" class="radio ">By ID : Phone Numbers will be retrieved based on the order ID</label></span><span><input
                                                type="radio" class="input-radio " value="dynamic"
                                                name="woo-ishaarat-cl[customer-list-search-type]"
                                                id="woo-ishaarat-cl[customer-list-search-type]_dynamic"
                                        <?= (isset($customer_list_data['customer-list-search-type']) && $customer_list_data['customer-list-search-type'] == 'dynamic') ? 'checked="checked"' : '';?>
                                        ><label
                                                for="woo-ishaarat-cl[customer-list-search-type]_dynamic" class="radio ">Dynamically : Phone Numbers will be retrieved based on some parameters</label></span>
								</div>
							</span>
                    </td>
                </tr>
                <tr class="woo-ishaarat-customer-list-manual">
                    <td class="woo-ishaarat-table-label"><strong>Extraction by ID</strong><br>Provide the order ID, we
                        must use for retrieve the Phone Numbers
                    </td>
                    <td><span class="homescript-input-wrapper"><input type="text" class="input-text wooishaarat-query"
                                                                      name="woo-ishaarat-cl[customer-list-by-id]"
                                                                      id="woo-ishaarat-cl[customer-list-by-id]"
                                                                      placeholder="separate the order ID by commas"
                                                                      value="<?= $customer_list_data['customer-list-by-id'] ?? '';?> "></span></td>
                </tr>
                <tr class="woo-ishaarat-customer-list-dynamic" style="display: none;">
                    <td class="woo-ishaarat-table-label"><strong>Relationship between Extraction Rules types </strong>
                    </td>
                    <td>
							<span class="homescript-input-wrapper">
								<select name="woo-ishaarat-cl[customer-list-relationship]"
                                        id="woo-ishaarat-cl[customer-list-relationship]" class="select ">
									<option value="and" <?= (isset($customer_list_data['customer-list-relationship']) && $customer_list_data['customer-list-relationship'] == 'and') ? 'selected="selected"' : '';?> >AND</option>
									<option value="or"  <?= (isset($customer_list_data['customer-list-relationship']) && $customer_list_data['customer-list-relationship'] == 'or') ? 'selected="selected"' : '';?> >OR</option>
								</select>
							</span>
                    </td>
                </tr>
                <tr class="woo-ishaarat-customer-list-dynamic" style="display: none;">
                    <td class="woo-ishaarat-table-label"><strong>Extraction Rules types :</strong><br>How would you like
                        to get order(s) that contain(s) data related to the customer(s) you want to include into the
                        list?
                    </td>
                    <td>
                        <p id="wooishaarat-custom-fields-block">
                    </td>
                </tr>
                <tr class="">
                    <td class="woo-ishaarat-table-label"></td>
                    <td>
                        <div class="wooishaarat-search-customers"><input type="submit" name="submit"
                                                                         id="wooishaarat_add_custom_filters"
                                                                         class="button button-primary" value="Add Rule"
                                                                         style="display: none;">&nbsp;<input
                                    type="submit" name="submit" id="wooishaarat_search" class="button button-primary"
                                    value="Search Customers"> &nbsp;
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <br>
            <div class="wooishaarat-cl-loader" style="display: none;"></div>
            <div class="wooishaarat-search-list">
            </div>

        </div>
        <?php
    }

    public static function woo_ishaarat_get_customers_list()
    {
        // Verify nonce for security (you should include nonce in your request)
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'woo-ishaarat-ajax-nonce')) {
            wp_send_json_error(array('message' => 'Security check failed.'));
        }
        $data = $_POST['data'];
        $user_ids = self::woo_ishaarat_query_customers_list($data);
        echo "<strong>". count($user_ids) . " customer(s) found </strong><br />";
        array_map(function($user){
            echo "[<strong> `{$user['_billing_first_name']} {$user['_billing_last_name']}` => `{$user['_billing_country']}` </strong> | `{$user['_billing_phone']}` ]";
        }, $user_ids);
        die;
    }
    public static function woo_ishaarat_query_customers_list($data, $return_order_ids = true)
    {
        do_action( 'woo_ishaarat_before_get_customer_list', $data);
        $data = apply_filters('woo_ishaarat_before_get_customer_list', $data);
        $search_type = $data['customer-list-search-type'] ?? 'dynamic';
        $relation = $data['customer-list-relationship'] ?? 'AND';
        $rules = [
            'relation' => $relation
        ];
        $args = [
            'post_type' => 'shop_order',
            'posts_per_page' => -1,
        ];
        $status = 'any';
        if($search_type == 'by-id'){
            $args['post__in'] = explode(',', $data['customer-list-by-id']);

        }else if($search_type == 'dynamic'){
            $filters = array_filter($data, function ($item) {
                return isset($item['cl-rules']) && isset($item['cl-options']);
            });

            $status_rule = [];
            foreach ($filters as $key => $filter) {
                $rule = $filter['cl-rules'];
                $options = $filter['cl-options'];
                $values = $filter['cl-values'];
                if($rule == 'shop_order'){
                    $status_rule['condition'] = $options;
                    $status_rule['values'] = $values;
                    continue;
                }
                if ($rule == '_customer_role')
                    $rule = '_customer_user';

                if($rule == '_billing_email'){
                    if($options == 'in')
                        $options = 'like';
                    elseif ($options == 'not-in')
                        $options = 'not like';
                }
                if ($options == 'on') {
                    $values = 1;
                    unset($options);
                } else if ($options == 'off') {
                    $values = 0;
                    unset($options);
                }
                if (strpos($rule, 'date') !== false){
                    if($options == 'in')
                        $options = '=';
                    elseif ($options == 'not-in')
                        $options = '!=';
                    $rule_item['type'] = 'DATE';
                }
                $rule_item = [
                    'key' => $rule,
                    'value' => $values,
                    'compare' => $options ?? '='
                ];

                if (strpos($rule, 'date') !== false){
                    $rule_item['type'] = 'DATE';
                }
                $rules[] = $rule_item;
            }
            $all_statuses = array_keys(wc_get_order_statuses());
            if(!empty($status_rule)){
                if($status_rule['condition'] == 'in')
                    $status = $status_rule['values'];
                else
                    $status = array_diff($all_statuses, $status_rule['values']);
            }
            $args['meta_query'] = $rules;

        }
        $args['post_status'] = $status;
        $user_ids = [];
        $order_ids = [];
        $query = new WP_Query($args);
        $posts = $query->get_posts();
        foreach ($posts as $post) {
            if($return_order_ids){
                $order_ids[] = $post->ID;
                continue;
            }
            $user_id = $post->post_author;
            if (!in_array($user_id, array_keys($user_ids))) {
                $user_ids[$user_id] = [
                    '_billing_first_name' => $post->_billing_first_name,
                    '_billing_last_name' => $post->_billing_last_name,
                    '_billing_country' => $post->_billing_country,
                    '_billing_phone' => $post->_billing_phone
                ];
            }
        }
        if($return_order_ids){
            do_action( 'woo_ishaarat_after_get_customer_list', $data, $order_ids );
            return $order_ids;
        }
        do_action( 'woo_ishaarat_after_get_customer_list', $data, $user_ids );
        return $user_ids;
    }

    /**
     * This function save the customer list data to the db.
     *
     * @param int $post_id Customer List ID.
     *
     * @return void
     */
    public static function save_customer_list($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( !current_user_can( 'edit_post', $post_id ) )
            return;
        $customer_list = $_POST['woo-ishaarat-cl'] ?? [];
        update_post_meta($post_id, 'woo-ishaarat-cl', $customer_list);
    }
}

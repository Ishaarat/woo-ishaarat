<?php

class Woo_Ishaarat_Globals {

	/**
	 * This function loads the globals variable of the plugin.
	 *
	 * @return void
	 */
	public static function init() {
		global $ishaarat_helper;
		global $ishaarat_wa_loader;
		$ishaarat_helper        = new Woo_Ishaarat_Helper();
		$ishaarat_wa_loader     = new Woo_Ishaarat_WA();

		Woo_Ishaarat_Activator::activate();
	}

}

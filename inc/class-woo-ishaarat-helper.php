<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-helper.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
class Woo_Ishaarat_Helper {

	/***
	 * This function returns the name of all world country and their country code.
	 *
	 * @return array
	 */
	public static function get_worldwide_country_code() {
		return array(
			'AD' => array(
				'name' => 'ANDORRA',
				'code' => '376',
			),
			'AE' => array(
				'name' => 'UNITED ARAB EMIRATES',
				'code' => '971',
			),
			'AF' => array(
				'name' => 'AFGHANISTAN',
				'code' => '93',
			),
			'AG' => array(
				'name' => 'ANTIGUA AND BARBUDA',
				'code' => '1268',
			),
			'AI' => array(
				'name' => 'ANGUILLA',
				'code' => '1264',
			),
			'AL' => array(
				'name' => 'ALBANIA',
				'code' => '355',
			),
			'AM' => array(
				'name' => 'ARMENIA',
				'code' => '374',
			),
			'AN' => array(
				'name' => 'NETHERLANDS ANTILLES',
				'code' => '599',
			),
			'AO' => array(
				'name' => 'ANGOLA',
				'code' => '244',
			),
			'AQ' => array(
				'name' => 'ANTARCTICA',
				'code' => '672',
			),
			'AR' => array(
				'name' => 'ARGENTINA',
				'code' => '54',
			),
			'AS' => array(
				'name' => 'AMERICAN SAMOA',
				'code' => '1684',
			),
			'AT' => array(
				'name' => 'AUSTRIA',
				'code' => '43',
			),
			'AU' => array(
				'name' => 'AUSTRALIA',
				'code' => '61',
			),
			'AW' => array(
				'name' => 'ARUBA',
				'code' => '297',
			),
			'AZ' => array(
				'name' => 'AZERBAIJAN',
				'code' => '994',
			),
			'BA' => array(
				'name' => 'BOSNIA AND HERZEGOVINA',
				'code' => '387',
			),
			'BB' => array(
				'name' => 'BARBADOS',
				'code' => '1246',
			),
			'BD' => array(
				'name' => 'BANGLADESH',
				'code' => '880',
			),
			'BE' => array(
				'name' => 'BELGIUM',
				'code' => '32',
			),
			'BF' => array(
				'name' => 'BURKINA FASO',
				'code' => '226',
			),
			'BG' => array(
				'name' => 'BULGARIA',
				'code' => '359',
			),
			'BH' => array(
				'name' => 'BAHRAIN',
				'code' => '973',
			),
			'BI' => array(
				'name' => 'BURUNDI',
				'code' => '257',
			),
			'BJ' => array(
				'name' => 'BENIN',
				'code' => '229',
			),
			'BL' => array(
				'name' => 'SAINT BARTHELEMY',
				'code' => '590',
			),
			'BM' => array(
				'name' => 'BERMUDA',
				'code' => '1441',
			),
			'BN' => array(
				'name' => 'BRUNEI DARUSSALAM',
				'code' => '673',
			),
			'BO' => array(
				'name' => 'BOLIVIA',
				'code' => '591',
			),
			'BR' => array(
				'name' => 'BRAZIL',
				'code' => '55',
			),
			'BS' => array(
				'name' => 'BAHAMAS',
				'code' => '1242',
			),
			'BT' => array(
				'name' => 'BHUTAN',
				'code' => '975',
			),
			'BW' => array(
				'name' => 'BOTSWANA',
				'code' => '267',
			),
			'BY' => array(
				'name' => 'BELARUS',
				'code' => '375',
			),
			'BZ' => array(
				'name' => 'BELIZE',
				'code' => '501',
			),
			'CA' => array(
				'name' => 'CANADA',
				'code' => '1',
			),
			'CC' => array(
				'name' => 'COCOS (KEELING) ISLANDS',
				'code' => '61',
			),
			'CD' => array(
				'name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
				'code' => '243',
			),
			'CF' => array(
				'name' => 'CENTRAL AFRICAN REPUBLIC',
				'code' => '236',
			),
			'CG' => array(
				'name' => 'CONGO',
				'code' => '242',
			),
			'CH' => array(
				'name' => 'SWITZERLAND',
				'code' => '41',
			),
			'CI' => array(
				'name' => 'COTE D IVOIRE',
				'code' => '225',
			),
			'CK' => array(
				'name' => 'COOK ISLANDS',
				'code' => '682',
			),
			'CL' => array(
				'name' => 'CHILE',
				'code' => '56',
			),
			'CM' => array(
				'name' => 'CAMEROON',
				'code' => '237',
			),
			'CN' => array(
				'name' => 'CHINA',
				'code' => '86',
			),
			'CO' => array(
				'name' => 'COLOMBIA',
				'code' => '57',
			),
			'CR' => array(
				'name' => 'COSTA RICA',
				'code' => '506',
			),
			'CU' => array(
				'name' => 'CUBA',
				'code' => '53',
			),
			'CV' => array(
				'name' => 'CAPE VERDE',
				'code' => '238',
			),
			'CX' => array(
				'name' => 'CHRISTMAS ISLAND',
				'code' => '61',
			),
			'CY' => array(
				'name' => 'CYPRUS',
				'code' => '357',
			),
			'CZ' => array(
				'name' => 'CZECH REPUBLIC',
				'code' => '420',
			),
			'DE' => array(
				'name' => 'GERMANY',
				'code' => '49',
			),
			'DJ' => array(
				'name' => 'DJIBOUTI',
				'code' => '253',
			),
			'DK' => array(
				'name' => 'DENMARK',
				'code' => '45',
			),
			'DM' => array(
				'name' => 'DOMINICA',
				'code' => '1767',
			),
			'DO' => array(
				'name' => 'DOMINICAN REPUBLIC',
				'code' => '1809',
			),
			'DZ' => array(
				'name' => 'ALGERIA',
				'code' => '213',
			),
			'EC' => array(
				'name' => 'ECUADOR',
				'code' => '593',
			),
			'EE' => array(
				'name' => 'ESTONIA',
				'code' => '372',
			),
			'EG' => array(
				'name' => 'EGYPT',
				'code' => '20',
			),
			'ER' => array(
				'name' => 'ERITREA',
				'code' => '291',
			),
			'ES' => array(
				'name' => 'SPAIN',
				'code' => '34',
			),
			'ET' => array(
				'name' => 'ETHIOPIA',
				'code' => '251',
			),
			'FI' => array(
				'name' => 'FINLAND',
				'code' => '358',
			),
			'FJ' => array(
				'name' => 'FIJI',
				'code' => '679',
			),
			'FK' => array(
				'name' => 'FALKLAND ISLANDS (MALVINAS)',
				'code' => '500',
			),
			'FM' => array(
				'name' => 'MICRONESIA, FEDERATED STATES OF',
				'code' => '691',
			),
			'FO' => array(
				'name' => 'FAROE ISLANDS',
				'code' => '298',
			),
			'FR' => array(
				'name' => 'FRANCE',
				'code' => '33',
			),
			'GA' => array(
				'name' => 'GABON',
				'code' => '241',
			),
			'GB' => array(
				'name' => 'UNITED KINGDOM',
				'code' => '44',
			),
			'GD' => array(
				'name' => 'GRENADA',
				'code' => '1473',
			),
			'GE' => array(
				'name' => 'GEORGIA',
				'code' => '995',
			),
			'GH' => array(
				'name' => 'GHANA',
				'code' => '233',
			),
			'GI' => array(
				'name' => 'GIBRALTAR',
				'code' => '350',
			),
			'GL' => array(
				'name' => 'GREENLAND',
				'code' => '299',
			),
			'GM' => array(
				'name' => 'GAMBIA',
				'code' => '220',
			),
			'GN' => array(
				'name' => 'GUINEA',
				'code' => '224',
			),
			'GQ' => array(
				'name' => 'EQUATORIAL GUINEA',
				'code' => '240',
			),
			'GR' => array(
				'name' => 'GREECE',
				'code' => '30',
			),
			'GT' => array(
				'name' => 'GUATEMALA',
				'code' => '502',
			),
			'GU' => array(
				'name' => 'GUAM',
				'code' => '1671',
			),
			'GW' => array(
				'name' => 'GUINEA-BISSAU',
				'code' => '245',
			),
			'GY' => array(
				'name' => 'GUYANA',
				'code' => '592',
			),
			'HK' => array(
				'name' => 'HONG KONG',
				'code' => '852',
			),
			'HN' => array(
				'name' => 'HONDURAS',
				'code' => '504',
			),
			'HR' => array(
				'name' => 'CROATIA',
				'code' => '385',
			),
			'HT' => array(
				'name' => 'HAITI',
				'code' => '509',
			),
			'HU' => array(
				'name' => 'HUNGARY',
				'code' => '36',
			),
			'ID' => array(
				'name' => 'INDONESIA',
				'code' => '62',
			),
			'IE' => array(
				'name' => 'IRELAND',
				'code' => '353',
			),
			'IL' => array(
				'name' => 'ISRAEL',
				'code' => '972',
			),
			'IM' => array(
				'name' => 'ISLE OF MAN',
				'code' => '44',
			),
			'IN' => array(
				'name' => 'INDIA',
				'code' => '91',
			),
			'IQ' => array(
				'name' => 'IRAQ',
				'code' => '964',
			),
			'IR' => array(
				'name' => 'IRAN, ISLAMIC REPUBLIC OF',
				'code' => '98',
			),
			'IS' => array(
				'name' => 'ICELAND',
				'code' => '354',
			),
			'IT' => array(
				'name' => 'ITALY',
				'code' => '39',
			),
			'JM' => array(
				'name' => 'JAMAICA',
				'code' => '1876',
			),
			'JO' => array(
				'name' => 'JORDAN',
				'code' => '962',
			),
			'JP' => array(
				'name' => 'JAPAN',
				'code' => '81',
			),
			'KE' => array(
				'name' => 'KENYA',
				'code' => '254',
			),
			'KG' => array(
				'name' => 'KYRGYZSTAN',
				'code' => '996',
			),
			'KH' => array(
				'name' => 'CAMBODIA',
				'code' => '855',
			),
			'KI' => array(
				'name' => 'KIRIBATI',
				'code' => '686',
			),
			'KM' => array(
				'name' => 'COMOROS',
				'code' => '269',
			),
			'KN' => array(
				'name' => 'SAINT KITTS AND NEVIS',
				'code' => '1869',
			),
			'KP' => array(
				'name' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
				'code' => '850',
			),
			'KR' => array(
				'name' => 'KOREA REPUBLIC OF',
				'code' => '82',
			),
			'KW' => array(
				'name' => 'KUWAIT',
				'code' => '965',
			),
			'KY' => array(
				'name' => 'CAYMAN ISLANDS',
				'code' => '1345',
			),
			'KZ' => array(
				'name' => 'KAZAKSTAN',
				'code' => '7',
			),
			'LA' => array(
				'name' => 'LAO PEOPLES DEMOCRATIC REPUBLIC',
				'code' => '856',
			),
			'LB' => array(
				'name' => 'LEBANON',
				'code' => '961',
			),
			'LC' => array(
				'name' => 'SAINT LUCIA',
				'code' => '1758',
			),
			'LI' => array(
				'name' => 'LIECHTENSTEIN',
				'code' => '423',
			),
			'LK' => array(
				'name' => 'SRI LANKA',
				'code' => '94',
			),
			'LR' => array(
				'name' => 'LIBERIA',
				'code' => '231',
			),
			'LS' => array(
				'name' => 'LESOTHO',
				'code' => '266',
			),
			'LT' => array(
				'name' => 'LITHUANIA',
				'code' => '370',
			),
			'LU' => array(
				'name' => 'LUXEMBOURG',
				'code' => '352',
			),
			'LV' => array(
				'name' => 'LATVIA',
				'code' => '371',
			),
			'LY' => array(
				'name' => 'LIBYAN ARAB JAMAHIRIYA',
				'code' => '218',
			),
			'MA' => array(
				'name' => 'MOROCCO',
				'code' => '212',
			),
			'MC' => array(
				'name' => 'MONACO',
				'code' => '377',
			),
			'MD' => array(
				'name' => 'MOLDOVA, REPUBLIC OF',
				'code' => '373',
			),
			'ME' => array(
				'name' => 'MONTENEGRO',
				'code' => '382',
			),
			'MF' => array(
				'name' => 'SAINT MARTIN',
				'code' => '1599',
			),
			'MG' => array(
				'name' => 'MADAGASCAR',
				'code' => '261',
			),
			'MH' => array(
				'name' => 'MARSHALL ISLANDS',
				'code' => '692',
			),
			'MK' => array(
				'name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
				'code' => '389',
			),
			'ML' => array(
				'name' => 'MALI',
				'code' => '223',
			),
			'MM' => array(
				'name' => 'MYANMAR',
				'code' => '95',
			),
			'MN' => array(
				'name' => 'MONGOLIA',
				'code' => '976',
			),
			'MO' => array(
				'name' => 'MACAU',
				'code' => '853',
			),
			'MP' => array(
				'name' => 'NORTHERN MARIANA ISLANDS',
				'code' => '1670',
			),
			'MR' => array(
				'name' => 'MAURITANIA',
				'code' => '222',
			),
			'MS' => array(
				'name' => 'MONTSERRAT',
				'code' => '1664',
			),
			'MT' => array(
				'name' => 'MALTA',
				'code' => '356',
			),
			'MU' => array(
				'name' => 'MAURITIUS',
				'code' => '230',
			),
			'MV' => array(
				'name' => 'MALDIVES',
				'code' => '960',
			),
			'MW' => array(
				'name' => 'MALAWI',
				'code' => '265',
			),
			'MX' => array(
				'name' => 'MEXICO',
				'code' => '52',
			),
			'MY' => array(
				'name' => 'MALAYSIA',
				'code' => '60',
			),
			'MZ' => array(
				'name' => 'MOZAMBIQUE',
				'code' => '258',
			),
			'NA' => array(
				'name' => 'NAMIBIA',
				'code' => '264',
			),
			'NC' => array(
				'name' => 'NEW CALEDONIA',
				'code' => '687',
			),
			'NE' => array(
				'name' => 'NIGER',
				'code' => '227',
			),
			'NG' => array(
				'name' => 'NIGERIA',
				'code' => '234',
			),
			'NI' => array(
				'name' => 'NICARAGUA',
				'code' => '505',
			),
			'NL' => array(
				'name' => 'NETHERLANDS',
				'code' => '31',
			),
			'NO' => array(
				'name' => 'NORWAY',
				'code' => '47',
			),
			'NP' => array(
				'name' => 'NEPAL',
				'code' => '977',
			),
			'NR' => array(
				'name' => 'NAURU',
				'code' => '674',
			),
			'NU' => array(
				'name' => 'NIUE',
				'code' => '683',
			),
			'NZ' => array(
				'name' => 'NEW ZEALAND',
				'code' => '64',
			),
			'OM' => array(
				'name' => 'OMAN',
				'code' => '968',
			),
			'PA' => array(
				'name' => 'PANAMA',
				'code' => '507',
			),
			'PE' => array(
				'name' => 'PERU',
				'code' => '51',
			),
			'PF' => array(
				'name' => 'FRENCH POLYNESIA',
				'code' => '689',
			),
			'PG' => array(
				'name' => 'PAPUA NEW GUINEA',
				'code' => '675',
			),
			'PH' => array(
				'name' => 'PHILIPPINES',
				'code' => '63',
			),
			'PK' => array(
				'name' => 'PAKISTAN',
				'code' => '92',
			),
			'PL' => array(
				'name' => 'POLAND',
				'code' => '48',
			),
			'PM' => array(
				'name' => 'SAINT PIERRE AND MIQUELON',
				'code' => '508',
			),
			'PN' => array(
				'name' => 'PITCAIRN',
				'code' => '870',
			),
			'PR' => array(
				'name' => 'PUERTO RICO',
				'code' => '1',
			),
			'PT' => array(
				'name' => 'PORTUGAL',
				'code' => '351',
			),
			'PW' => array(
				'name' => 'PALAU',
				'code' => '680',
			),
			'PY' => array(
				'name' => 'PARAGUAY',
				'code' => '595',
			),
			'QA' => array(
				'name' => 'QATAR',
				'code' => '974',
			),
			'RO' => array(
				'name' => 'ROMANIA',
				'code' => '40',
			),
			'RS' => array(
				'name' => 'SERBIA',
				'code' => '381',
			),
			'RU' => array(
				'name' => 'RUSSIAN FEDERATION',
				'code' => '7',
			),
			'RW' => array(
				'name' => 'RWANDA',
				'code' => '250',
			),
			'SA' => array(
				'name' => 'SAUDI ARABIA',
				'code' => '966',
			),
			'SB' => array(
				'name' => 'SOLOMON ISLANDS',
				'code' => '677',
			),
			'SC' => array(
				'name' => 'SEYCHELLES',
				'code' => '248',
			),
			'SD' => array(
				'name' => 'SUDAN',
				'code' => '249',
			),
			'SE' => array(
				'name' => 'SWEDEN',
				'code' => '46',
			),
			'SG' => array(
				'name' => 'SINGAPORE',
				'code' => '65',
			),
			'SH' => array(
				'name' => 'SAINT HELENA',
				'code' => '290',
			),
			'SI' => array(
				'name' => 'SLOVENIA',
				'code' => '386',
			),
			'SK' => array(
				'name' => 'SLOVAKIA',
				'code' => '421',
			),
			'SL' => array(
				'name' => 'SIERRA LEONE',
				'code' => '232',
			),
			'SM' => array(
				'name' => 'SAN MARINO',
				'code' => '378',
			),
			'SN' => array(
				'name' => 'SENEGAL',
				'code' => '221',
			),
			'SO' => array(
				'name' => 'SOMALIA',
				'code' => '252',
			),
			'SR' => array(
				'name' => 'SURINAME',
				'code' => '597',
			),
			'ST' => array(
				'name' => 'SAO TOME AND PRINCIPE',
				'code' => '239',
			),
			'SV' => array(
				'name' => 'EL SALVADOR',
				'code' => '503',
			),
			'SY' => array(
				'name' => 'SYRIAN ARAB REPUBLIC',
				'code' => '963',
			),
			'SZ' => array(
				'name' => 'SWAZILAND',
				'code' => '268',
			),
			'TC' => array(
				'name' => 'TURKS AND CAICOS ISLANDS',
				'code' => '1649',
			),
			'TD' => array(
				'name' => 'CHAD',
				'code' => '235',
			),
			'TG' => array(
				'name' => 'TOGO',
				'code' => '228',
			),
			'TH' => array(
				'name' => 'THAILAND',
				'code' => '66',
			),
			'TJ' => array(
				'name' => 'TAJIKISTAN',
				'code' => '992',
			),
			'TK' => array(
				'name' => 'TOKELAU',
				'code' => '690',
			),
			'TL' => array(
				'name' => 'TIMOR-LESTE',
				'code' => '670',
			),
			'TM' => array(
				'name' => 'TURKMENISTAN',
				'code' => '993',
			),
			'TN' => array(
				'name' => 'TUNISIA',
				'code' => '216',
			),
			'TO' => array(
				'name' => 'TONGA',
				'code' => '676',
			),
			'TR' => array(
				'name' => 'TURKEY',
				'code' => '90',
			),
			'TT' => array(
				'name' => 'TRINIDAD AND TOBAGO',
				'code' => '1868',
			),
			'TV' => array(
				'name' => 'TUVALU',
				'code' => '688',
			),
			'TW' => array(
				'name' => 'TAIWAN, PROVINCE OF CHINA',
				'code' => '886',
			),
			'TZ' => array(
				'name' => 'TANZANIA, UNITED REPUBLIC OF',
				'code' => '255',
			),
			'UA' => array(
				'name' => 'UKRAINE',
				'code' => '380',
			),
			'UG' => array(
				'name' => 'UGANDA',
				'code' => '256',
			),
			'US' => array(
				'name' => 'UNITED STATES',
				'code' => '1',
			),
			'UY' => array(
				'name' => 'URUGUAY',
				'code' => '598',
			),
			'UZ' => array(
				'name' => 'UZBEKISTAN',
				'code' => '998',
			),
			'VA' => array(
				'name' => 'HOLY SEE (VATICAN CITY STATE)',
				'code' => '39',
			),
			'VC' => array(
				'name' => 'SAINT VINCENT AND THE GRENADINES',
				'code' => '1784',
			),
			'VE' => array(
				'name' => 'VENEZUELA',
				'code' => '58',
			),
			'VG' => array(
				'name' => 'VIRGIN ISLANDS, BRITISH',
				'code' => '1284',
			),
			'VI' => array(
				'name' => 'VIRGIN ISLANDS, U.S.',
				'code' => '1340',
			),
			'VN' => array(
				'name' => 'VIET NAM',
				'code' => '84',
			),
			'VU' => array(
				'name' => 'VANUATU',
				'code' => '678',
			),
			'WF' => array(
				'name' => 'WALLIS AND FUTUNA',
				'code' => '681',
			),
			'WS' => array(
				'name' => 'SAMOA',
				'code' => '685',
			),
			'XK' => array(
				'name' => 'KOSOVO',
				'code' => '381',
			),
			'YE' => array(
				'name' => 'YEMEN',
				'code' => '967',
			),
			'YT' => array(
				'name' => 'MAYOTTE',
				'code' => '262',
			),
			'ZA' => array(
				'name' => 'SOUTH AFRICA',
				'code' => '27',
			),
			'ZM' => array(
				'name' => 'ZAMBIA',
				'code' => '260',
			),
			'ZW' => array(
				'name' => 'ZIMBABWE',
				'code' => '263',
			),
		);
	}


	/**
	 * This function return the right country name associated to a country code.
	 *
	 * @param $town
	 *
	 * @return array|mixed
	 */
	public static function get_country_town_code( $town ) {
		$country = self::get_worldwide_country_code();
		foreach ( $country as $country_name => $indicator ) {
			if ( $town == $country_name ) {
				$country_code = $indicator['code'];

				return $country_code;
			}
		}

		return null;
	}

	public static function get_country_name( $town ) {
		$code_country_code = self::get_country_town_code( $town );

		$country = self::get_worldwide_country_code();
		foreach ( $country as $country_name => $indicator ) {
			if ( $code_country_code == $indicator['code'] ) {
				return $indicator['name'];
			}
		}

		return null;
	}

	/**
	 * Remove whitespaces,dots and parentheses from numbers.
	 *
	 * @param int $phone_number Phone number to sanitize.
	 *
	 * @return int Sanitize phone number.
	 */
	public static function split_space_in_numbers( $phone_number ) {
		if ( ! empty( $phone_number ) || null != $phone_number ) {
			$phone_number = preg_replace( '/(\s+)|(\W+)/', '', $phone_number );
		}

		return $phone_number;
	}


	/**
	 * Checking if WooCommerce is activated or not on the store and display banner.
	 */
	public static function is_wc_active( $page_type = 'body' ) {
		$is_active = true;
		if ( ! class_exists( 'WooCommerce' ) ) {
			if ( $page_type == 'admin' ) {
				echo "<div class='notice notice-error'>";
			} else {
				echo "<div class='wrap'>";
			}
			_e( 'Please install and activate <strong>WooCommerce</strong> before using <strong> Ishaarat Order notifications & Abandoned Carts for WooCommerce </strong>.', WOO_ISHAARAT_PLUGIN_NAME );
			echo '</div>';
			$is_active = false;
		}

		return $is_active;
	}

	public function is_ishaarat_page( $page_type = 'main' ) {
		global $pagenow, $typenow;
		$is_child   = false;
		$page_array = apply_filters(
			'woo_ishaarat_cpt_pages',
			array(
				'woo_ishaarat-whatsapp-msg',
				'shop_order',
				'ishaarat_cl',
			)
		);

		if ( isset( $_GET['post'] ) ) {
			$post_id   = sanitize_post( esc_attr( $_GET['post'] ) );
			$is_child  = true;
			$post_type = get_post_type( $post_id );
		}

		if ( $page_type == 'main' ) {
			if ( ( 'admin.php' == $pagenow && ( isset( $_GET['page'] ) && ( $_GET['page'] == 'woo-ishaarat' || ( preg_match( '/woo-ishaarat/', $_GET['page'] ) == true ) ) ) ) || in_array( $typenow, $page_array ) ) {
				return true;
			}
		}

		if ( $page_type == 'cl' ) {
			if ( in_array( $typenow, $page_array ) ) {
				return true;
			}
		}

		return false;
	}

	public function is_product_page() {
		return is_product();
	}
	public static function get_wp_roles() {
		$roles_obj = new WP_Roles();

		return $roles_obj->get_names();
	}

	public static function get_wc_country() {
		$countries_obj = new WC_Countries();

		return $countries_obj->__get( 'countries' );
	}

	public static function get_wc_payment_gateways() {
		$gateways         = WC()->payment_gateways->get_available_payment_gateways();
		$enabled_gateways = array();
		foreach ( $gateways as $gateway ) {
			if ( $gateway->enabled == 'yes' ) {
				$enabled_gateways[ $gateway->id ] = $gateway->title;
			}
		}

		return $enabled_gateways;
	}

	public static function get_wc_shipping_methods() {
		$wc_shipping = WC_Shipping::instance();
		$methods     = array();
		foreach ( $wc_shipping->get_shipping_methods() as $method_id => $method ) {
			$methods[ $method_id ] = $method->method_title;
		}

		return $methods;
	}

	public static function generate_random_string( $length = 5 ) {
		$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen( $characters );
		$randomString     = '';
		for ( $i = 0; $i < $length; $i ++ ) {
			$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
		}

		return $randomString;
	}
	/**
	 * This method allows to get all bulk sms.
	 *
	 * @return array
	 */
	public static function get_all_bulk_msgs() {
		$all_lists = get_posts(
			array(
				'numberposts' => - 1,
				'post_status' => array( 'publish' ),
				'post_type'   => 'woo_ishaarat-whatsapp-msg',
			)
		);
		$lists     = array();
		foreach ( $all_lists as $post ) {
			$lists[ $post->ID ] = $post->post_title;
		}

		return $lists;
	}
	/**
	 * This function return the timestamp of a date.
	 *
	 * @param string $date
	 *
	 * @return string
	 */
	public static function get_date_timestamp( string $date ) {
		return strtotime( $date );
	}


	/**
	 * This function return the operator for query the customer list.
	 *
	 * @return array
	 */
	public static function get_relationship() {
		return array(
			'and' => __( 'AND', WOO_ISHAARAT_PLUGIN_NAME ),
			'or'  => __( 'OR', WOO_ISHAARAT_PLUGIN_NAME ),
		);
	}
	/**
	 * This method allows to the get api credentials from the db.
	 *
	 * @return mixed
	 */
	public static function get_api_credentials() {
		$api_credentials_data = [
			'auth_key' => get_option( 'woo_ishaarat_api_auth_key' ),
			'app_key' => get_option( 'woo_ishaarat_api_app_key' )
		];
		return wp_json_encode(
			apply_filters( 'woo_ishaarat_api_credentials', $api_credentials_data )
		);
	}
	public static function get_right_phone_numbers( $country_code, $phone_number ) {

		if ( preg_match( '/^00' . $country_code . '/', $phone_number ) ) {
			$phone_number = preg_replace( '/^00' . $country_code . '/', '+', $phone_number );
		}
		if ( preg_match( '/^\+' . $country_code . '/', $phone_number ) ) {
			$phone_number = preg_replace( '/^\+' . $country_code . '/', '', $phone_number );
		}
		if ( substr( $phone_number, 0, 1 ) == 0 ) {
			$phone_number = substr( $phone_number, 1 );
		}
		if ( preg_match( '/^' . $country_code . '/', $phone_number ) ) {
			$phone_number = preg_replace( '/^' . $country_code . '/', '', $phone_number );
		}
		return self::split_space_in_numbers( $phone_number );
	}
	public static function get_list_of_tag_names() {
		return apply_filters( 'woo_ishaarat_get_tag_names', array(
			'/%shopname%/'           => ': Shop Name',
			'/%billing_name%/'       => ': Billing Name',
			'/%order_status%/'       => ': Order Status',
			'/%order_amount%/'       => ': Order Amount',
			'/%order_id%/'           => ': Order ID',
			'/%shipping_method%/'    => ': Shipping Method',
			'/%order_processed_at%/' => ': Order processed at',
			'/%shipping_amount%/'    => ': Shipping Amount',
			'/%first_name%/'         => ': First Name',
			'/%last_name%/'          => ': Last Name',
		) );
	}

	public static function get_list_of_tag_values( $order_id ) {
		$shopname   = get_bloginfo();
		$tag_values = array(
			'/%shopname%/' => $shopname,
		);
		if ( class_exists( 'WC_Order' ) ) {
			if ( ! is_null( $order_id ) ) {

				$_order = new WC_Order( $order_id );

				$billing_name    = $_order->get_formatted_billing_full_name();
				$order_status    = $_order->get_status();
				$order_amount    = $_order->get_total() . get_woocommerce_currency_symbol();
				$shipping_method = $_order->get_shipping_method();
				$order_bought_at = $_order->get_date_paid();
				$shipping_amount = $_order->get_shipping_total() . get_woocommerce_currency_symbol();
				$first_name      = $_order->get_billing_first_name();
				$last_name       = $_order->get_billing_last_name();

				$tag_values += array(

					'/%billing_name%/'    => $billing_name,
					'/%order_status%/'    => $order_status,
					'/%order_amount%/'    => $order_amount,
					'/%order_id%/'        => $order_id,
					'/%shipping_method%/' => $shipping_method,
					'/%order_bought_at%/' => $order_bought_at,
					'/%shipping_amount%/' => $shipping_amount,
					'/%first_name%/'      => $first_name,
					'/%last_name%/'       => $last_name
				);
			}
		}

		return apply_filters( 'woo_ishaarat_get_tag_values', $tag_values );
	}
	/**
	* This method decode the special characters found into the message to
	* send.
	*
	* @param string $order_id WC Order ID.
	* @param string $message Message to send.
	*
	* @return mixed
	*/
	public static function decode_message_to_send( $order_id, $message ) {

		$list_of_tag_values = self::get_list_of_tag_values( $order_id );

		return preg_replace( array_keys( $list_of_tag_values ), array_values( $list_of_tag_values ), $message );
	}


	/**
	 * This function convert a full date into timestamp.
	 *
	 * @param string $time
	 *
	 * @return int
	 */
	public static function convert_date_to_timestamp( $time ) {
		return strtotime( $time );
	}

	/**
	 * Get the current time based on the installation timezone.
	 * @return string The current date.
	 */
	public static function get_current_time() {
		$timezone_format = _x( 'd-m-Y | H:i:s', 'timezone date format' );

		return date_i18n( $timezone_format, false, true );
	}

	public static function convert_current_time_into_array() {
		$current_time                  = self::get_current_time();
		$convert_current_time          = array();
		$splitted_time                 = explode( '|', $current_time );
		$day_splitted                  = explode( '-', $splitted_time[0] );
		$convert_current_time['day']   = $day_splitted[0];
		$convert_current_time['month'] = $day_splitted[1];
		$convert_current_time['year']  = $day_splitted[2];

		$time_splitted                   = explode( ':', $splitted_time[1] );
		$convert_current_time['hours']   = $time_splitted[0];
		$convert_current_time['minutes'] = $time_splitted[1];
		$convert_current_time['seconds'] = $time_splitted[2];

		return $convert_current_time;
	}

	public static function get_csv_file_data_structure() {
		return array(
			'ID',
			'Full Name',
			'Phone Number',
			'Country'
		);
	}

	public static function read_csv_file( $file_path, $csv_structure ) {
		$file_handle = fopen( $file_path, 'r' );
		$rows        = array();
		while ( ! feof( $file_handle ) ) {
			$rows[] = fgetcsv( $file_handle, 1024, ",", '"' );
		}
		fclose( $file_handle );
		$data_jointure = array_intersect( $csv_structure, current( $rows ) );
		if ( empty( $data_jointure ) ) {
			return array();
		}
		unset( $rows[0] );

		return $rows;
	}

	public static function get_attachment_file_path( $attachment_id ) {
		$csv_file_url   = wp_get_attachment_url( $attachment_id );
		$site_url       = get_site_url() . '/';
		$real_file_path = str_replace( $site_url, ABSPATH, $csv_file_url );

		return $real_file_path;
	}

	public static function write_log( $log ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
	public static function log_errors( $errors ) {
		if ( function_exists( 'wc_get_logger' ) ) {
			$log = wc_get_logger();
			$log->error( $errors, array( 'source' => WOO_ISHAARAT_PLUGIN_NAME ) );
		} else {
			self::write_log( $errors );
		}

		return __( 'Message failed to send , please again later ! .', WOO_ISHAARAT_PLUGIN_NAME );
	}


	public static function get_country_name_from_code( $country_code ) {
		$country = self::get_worldwide_country_code();
		foreach ( $country as $country_name => $indicator ) {
			if ( $country_code == $indicator['code'] ) {
				return $indicator['name'];
			}
		}
	}
	public static function get_sms_status( $status_code ) {
		if ( $status_code == 'queued' || true == preg_match( '/^2([0-9]{1})([0-9]{1})$/', $status_code ) || 'ok' === $status_code ) {
			$message = __( 'Message successfully sent', WOO_ISHAARAT_PLUGIN_NAME );
		} else {
			$message = __( 'Message failed to sent', WOO_ISHAARAT_PLUGIN_NAME );
			self::log_errors( $status_code );
		}
		return apply_filters( 'woo_ishaarat_get_sms_status_code', $message, $status_code );
	}
}

if ( ! function_exists( 'array_key_first' ) ) {
	function array_key_first( array $array ) {
		if ( count( $array ) ) {
			reset( $array );

			return key( $array );
		}

		return null;
	}
}
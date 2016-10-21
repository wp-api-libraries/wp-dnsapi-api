<?php
/**
 * WP-DNSAPI-API (https://dns-api.org/)
 *
 * @package WP-DNSAPI-API
 */

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Check if class exists. */
if ( ! class_exists( 'DnsApiOrgAPI' ) ) {

	/**
	 * DnsApiOrgAPI API Class.
	 */
	class DnsApiOrgAPI {

		/**
		 * BaseAPI Endpoint
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://dns-api.org/';


		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}


		/**
		 * DNS Lookup
		 *
		 * @access public
		 * @param mixed $type Type.
		 * @param mixed $host Host.
		 * @return void
		 */
		function lookup( $type, $host ) {

			if ( empty( $type ) || empty( $host ) ) {
				return new WP_Error( 'response-error', __( "Please provide the Type and Host.", "text-domain" ) );
			}

			$request = $this->base_uri . $type . '/' . $host;

			return $this->fetch( $request );

		}

	}
}

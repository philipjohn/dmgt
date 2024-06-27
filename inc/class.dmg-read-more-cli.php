<?php
/**
 * class.dmg-read-more-cli.php
 *
 * This file contains the class definition for the Dmg_Read_More_CLI class.
 *
 * @package Dmg_Read_More
 */

namespace Dmg_Read_More;

use WP_CLI;
use WP_Query;

/**
 * Class Dmg_Read_More_CLI
 *
 * This class defines the WP-CLI command for the Dmg_Read_More plugin.
 * It searches for instances of the read more block in post content.
 *
 * @package Dmg_Read_More
 */
class Dmg_Read_More_CLI {

	/**
	 * Posts returned by the search query.
	 *
	 * @var array
	 */
	private $posts = [];

	/**
	 * Output format for the post IDs.
	 *
	 * One of `table’, ‘json’, ‘csv’, ‘yaml’, ‘count’.
	 *
	 * @var string
	 */
	private $output_format = 'csv';

	/**
	 * Fields to include in the output. Default: IDs only.
	 *
	 * @var array
	 */
	private $fields = [ 'ID' ];

	/**
	 * Results limit. Default: 100
	 *
	 * @var int
	 */
	private $limit = 100;

	/**
	 * Pagination offset.
	 *
	 * @var int
	 */
	private $offset = 0;

	/**
	 * Register the WP-CLI command.
	 *
	 * @return void
	 */
	public function register_command(): void {
		WP_CLI::add_command( 'dmg-read-more search', [ __CLASS__, 'find_read_more_blocks' ] );
	}

	/**
	 * Find instances of the read more block in post content.
	 *
	 * @param array $args The positional arguments.
	 * @param array $assoc_args The associative arguments.
	 *
	 * @return void
	 */
	public function find_read_more_blocks( array $args, array $assoc_args ): void {
		// Set the output format.
		if ( isset( $assoc_args['format'] ) ) {
			$this->output_format = WP_CLI\Utils\get_flag_value( $assoc_args, 'format' );
		}

		// Set the fields to include in the output.
		if ( isset( $assoc_args['fields'] ) ) {
			$this->fields = explode( ',', WP_CLI\Utils\get_flag_value( $assoc_args, 'fields' ) );
		}

		// Set the limit for the number of results.
		if ( isset( $assoc_args['limit'] ) ) {
			$this->limit = WP_CLI\Utils\get_flag_value( $assoc_args, 'limit' );

			// If the limit is greater than 100, tell the user it will be set to 100.
			if ( $this->limit > 100 || $this->limit < 0 ) {
				WP_CLI::warning( 'You have specified a limit greater than 100. This will be forced back to 100 to avoid bad things happening.' );
				$this->limit = 100;
			}
		}

		// Set the offset for pagination.
		if ( isset( $assoc_args['offset'] ) ) {
			$this->offset = WP_CLI\Utils\get_flag_value( $assoc_args, 'offset' );
		}

		// Do the search and output the results.
		$this->do_search();
		$this->output_results();
	}

	/**
	 * Perform the search for the read more block.
	 *
	 * This method sets the $posts property with the results of the search.
	 *
	 * @return void
	 */
	private function do_search(): void {
		// Get the posts containing our Read More Post Link block.
		$search_string = 'wp:dmgt/read-more-post-link';
		$results       = new WP_Query(
			[
				'post_type'      => 'post',
				'posts_per_page' => $this->limit,
				'offset'         => $this->offset,
				's'              => $search_string,
			]
		);

		// If there are no results, output a message and return.
		if ( 0 === $results->found_posts ) {
			WP_CLI::error( 'No read more blocks found.' );
		}

		// Check if we there are more results than the limit.
		if ( $results->found_posts > $this->limit && 0 === $this->offset ) {
			WP_CLI::warning(
				sprintf(
					'More than %d results found. Use the --limit and --offset flags to paginate.',
					$this->limit
				)
			 );
		}

		// Set the posts property with the results of the search filtered to the fields we want.
		$this->posts = array_map(
			function( $post ) {
				return array_intersect_key( (array) $post, array_flip( $this->fields ) );
			},
			$results->posts
		);
	}

	/**
	 * Output the results of the search.
	 *
	 * @return void
	 */
	private function output_results(): void {
		// WP_CLI::line( var_export( $this->posts, true ) );
		// Output the results.
		WP_CLI\Utils\format_items( $this->output_format, $this->posts, $this->fields );
	}
}
$commend = new Dmg_Read_More_CLI();
$commend->register_command();

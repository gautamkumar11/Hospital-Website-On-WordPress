<?php
/**
 * Filter - Doctor Listing Page
 */
if ( ! function_exists( 'inspiry_sort_doctors_filter' ) ) {
	/**
	 * Filter parameters to given query arguments
	 *
	 * @param $doctors_query_args  Array   query arguments
	 *
	 * @return mixed    Array   modified query arguments
	 */
	function inspiry_sort_doctors_filter( $doctors_query_args ) {

		global $theme_options;

		/*
		 * Sorting
		 */
		$sort_by = null;

		if ( isset( $theme_options['doctor_sort_by'] ) ) {

			$sort    = $theme_options['doctor_sort'];
			$sort_by = $theme_options['doctor_sort_by'];

			if ( $sort_by == 'doctor_speciality' ) {

				$doctors_query_args['orderby']  = 'meta_value';
				$doctors_query_args['meta_key'] = 'doctor_speciality';
				$doctors_query_args['order']    = ( $sort == 'ASC' ) ? 'ASC' : 'DESC';

			} elseif ( $sort_by == 'doctor_education' ) {

				$doctors_query_args['orderby']  = 'meta_value';
				$doctors_query_args['meta_key'] = 'doctor_education';
				$doctors_query_args['order']    = ( $sort == 'ASC' ) ? 'ASC' : 'DESC';

			} elseif ( $sort_by == 'date' ) {

				$doctors_query_args['orderby'] = 'date';
				$doctors_query_args['order']   = ( $sort == 'ASC' ) ? 'ASC' : 'DESC';

			} elseif ( $sort_by == 'title' ) {

				$doctors_query_args['orderby'] = 'title';
				$doctors_query_args['order']   = ( $sort == 'ASC' ) ? 'ASC' : 'DESC';

			}
		}

		return $doctors_query_args;
	}

	add_filter( 'inspiry_sort_doctors', 'inspiry_sort_doctors_filter' );
}
<?php
/*
Plugin Name: Paginate Atom Feeds
Version: 1.0
Description: Add "link rel=" links to your atom feeds
Author: duncanjbrown
Author URI: http://duncanjbrown.com
Text Domain: atom-pagination
*/

/**
 * Emit "first", "last", "next" and "previous" links in Atom feeds as specified
 * in The Atom Publishing Protocol (RFC5023). https://tools.ietf.org/html/rfc5023
 *
 * Collections can contain large numbers of Resources.  A client such as
 * a web spider or web browser might be overwhelmed if the response to a
 * GET contained every Entry in a Collection -- in turn the server might
 * also waste bandwidth and processing time on generating a response
 * that cannot be handled.  For this reason, servers MAY respond to
 * Collection GET requests with a Feed Document containing a partial
 * list of the Collection's members, and a link to the next partial list
 * feed, if it exists.  The first such partial list returned MUST
 * contain the most recently edited member Resources and MUST have an
 * atom:link with a "next" relation whose "href" value is the URI of the
 * next partial list of the Collection.  This next partial list will
 * contain the next most recently edited set of Member Resources (and an
 * atom:link to the following partial list if it exists).
 *
 * In addition to the "next" relation, partial list feeds MAY contain
 * link elements with "rel" attribute values of "previous", "first", and
 * "last", that can be used to navigate through the complete set of
 * entries in the Collection.
 *
 * NB: by default WP feeds do not fulfil the requirement to display the
 * most recently *edited* resources as the Atom feed is populated by a standard
 * wp_query which calls in posts by order of publication.
 */
function paf_add_pagination() {

    global $wp_query;
    $total_pages = $wp_query->max_num_pages;

    if( $total_pages === 1 ) {
        return;
    }

    $page_number = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

    // get the self_link of the feed (WP will only print, not return this value, hence output buffer)
    ob_start();
    self_link();
    $self_link = ob_get_clean();

    /**
     *  x_query_arg should be escaped:
     *  https://make.wordpress.org/plugins/2015/04/20/fixing-add_query_arg-and-remove_query_arg-usage/
     *
     *  self_link already calls it, though, so there's no need here.
     */
    $feed_path = remove_query_arg( 'paged', $self_link );

    echo "\n\t";

    // link rel=first
    printf( '<link rel="first" href="%s" />', add_query_arg( 'paged', 1, $feed_path ) );

    echo "\n\t";

    // link rel=last
    printf( '<link rel="last" href="%s" />', add_query_arg( 'paged', $total_pages, $feed_path ) );

    echo "\n\t";

    // link rel=previous
    if( $page_number > 1 ) {
        printf( '<link rel="previous" href="%s" />', add_query_arg( 'paged', $page_number - 1, $feed_path ) );
        echo "\n\t";
    }

    // link rel=next
    if( $page_number < $total_pages ) {
        printf( '<link rel="next" href="%s" />', add_query_arg( 'paged', $page_number + 1, $feed_path ) );
        echo "\n\t";
    }
}

add_action( 'atom_head', 'paf_add_pagination' );

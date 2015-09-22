=== Paginate Atom Feeds ===
Contributors: duncanjbrown
Tags: feeds, atom, pagination
Requires at least: 4.3
Tested up to: 4.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds link rel="next" and lin rel="prev" to the head of your atom feed.

== Description ==

After activating this plugin you'll find information resembling the following
in the head of any Atom feed with multiple pages:

  <link rel="first" href="http://wp.dev/feed/atom/?paged=1" />
  <link rel="last" href="http://wp.dev/feed/atom/?paged=10" />

And depending on your position in the feed, you may find the following too:

  <link rel="previous" href="http://wp.dev/feed/atom/?paged=5" />
  <link rel="next" href="http://wp.dev/feed/atom/?paged=7" />

For more details see the [Atom spec](https://tools.ietf.org/html/rfc5023)

== Changelog ==

= 1.0 =
* Initial release

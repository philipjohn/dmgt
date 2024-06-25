=== DMGT Read More ===
Contributors:      philipjohn
Tags:              block, read more
Tested up to:      6.5
Stable tag:        0.1.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Provides a block to show a read more link for a selected post, and a CLI command to find instances of the block in post content.

== Description ==

Usage:

= Read More Post Link block =

1. Open a new or existing post/page.
2. Use the block inserter to find the "Read More Post Link" block.
3. With the block selected, look to the sidebar to search for and select a post to link to.
4. Having selected a post, the link in the block will update and you can now save your changes.

= CLI: Search for Read More Post Link blocks =

The CLI command will search for any instances of the Read More Post Link block within post content.

Example: `wp dmg-read-more search`

By default the CLI command will return a simple list of IDs in CSV format (so one ID per line) and be limited to 100 results to avoid breaking all the things. There are arguments available to adapt the results:

* `format` Default: csv\
  Choose the format to use for the output - one of `table`, `json`, `csv`, `yaml` or `count`.
* `fields` Default: ID\
  A comma-separated list of fields to include in the output.
* `limit` Default: 100\
  Choose the number of posts to return. Don't make this too high or bad things could happen!
* `offset` Default: 0\
  Use this to get the next set of results. E.g. set this to 100 to skip the first 100 results.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/dmgt` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1.0 =
* First release\
Introduces the basic block and CLI search command.

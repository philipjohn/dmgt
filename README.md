# DMGT Read More

Provides a block to show a read more link for a selected post, and a CLI command to find instances of the block in post content.

## Usage

### Read More Post Link block

1. Open a new or existing post/page.
2. Use the block inserter to find the "Read More Post Link" block.
3. With the block selected, look to the sidebar to search for and select a post to link to.
4. Having selected a post, the link in the block will update and you can now save your changes.

### CLI: Search for Read More Post Link blocks

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

## Local Development

To get started with development, follow these steps:

1. Clone the repository: `git clone git@github.com:philipjohn/dmgt.git`
2. Move into the directory: `cd dmgt`
3. Make sure you're using the correct node version: `nvm use`
4. Start the local development environment and run the dev build: `npm run start`

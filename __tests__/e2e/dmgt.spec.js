import {
	createNewPost,
    enablePageDialogAccept,
	loginUser,
	visitAdminPage,
	insertBlock
} from '@wordpress/e2e-test-utils'

describe( 'ensure the plugin is active and working', () => {

    it ( 'verifies the plugin is active', async () => {
		// login as admin
		await loginUser();

		// visit the plugins page
		await visitAdminPage( 'plugins.php' );

		// Select the plugin based on slug and active class
        const activePlugin = await page.$x('//tr[contains(@class, "active") and contains(@data-slug, "dmgt")]');

		// Assert that our plugin is active by checking the HTML
		expect( activePlugin?.length ).toBe( 1 );
	});

})

describe( 'ensure the plugin is working', () => {

	beforeAll( async () => {
		await loginUser();
        await enablePageDialogAccept();
    } );

    beforeEach( async () => {
        await createNewPost();
    } );

	it ( 'verifies the block can be inserted', async () => {
		// Insert the block.
		await insertBlock( 'Read More Post Link' );

		// Assert that the block is in the editor
		expect( await page.$( '[data-type="dmgt/read-more-post-link"]' ) ).not.toBeNull();

		expect( await getEditedPostContent() ).toMatchSnapshot();
	} );
} )

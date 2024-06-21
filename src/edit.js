/**
 * WordPress Dependencies.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';

/**
 * Internal dependencies.
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {

	// Setup the block props, including our custom class name.
	const blockProps = useBlockProps(
		{
			className: 'dmg-read-more',
		}
	);

	// Extract the postID and linkText attributes.
	const { postID, linkText } = attributes;

	// Set state for the post title and link.
	const [ postTitle, setPostTitle ] = useState( '' );
	const [ postLink, setPostLink ] = useState( '' );

	// Fetch the post data and set the link title and URL.
	useEffect( () => {
		// Get the post object.
		async function fetchPostData() {
			const response = await wp.apiFetch( { path: `/wp/v2/posts/${ postID }` } );
			if ( ! response ) {
				return;
			}

			setPostTitle( response.title.rendered );
			setPostLink( response.link );
		}
		fetchPostData();
	}, [] );

	return (
		<p { ...blockProps }>
			{ postLink ? (
				<>{ linkText }: <a href={ postLink }>{ postTitle }</a></>
			) : (
				__( 'No post selected.', 'dmgt' )
			) }
		</p>
	);
}

/**
 * WordPress Dependencies.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';
import { Panel, PanelBody, ComboboxControl } from '@wordpress/components';

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

	// Extract the postTitle and postUrl attributes.
	const { postTitle, postUrl } = attributes;

	// Use State for post search results.
	const [ posts, setPosts ] = useState( [] );

	// Fetch the post data and set the link title and URL.
	useEffect( () => {
		// Get a list of 5 recent posts to show as suggestions.
		async function fetchRecentPosts() {
			const response = await wp.apiFetch( { path: '/wp/v2/posts?per_page=5' } );
			if ( ! response ) {
				return;
			}

			const latest = response.map( ( post ) => ( {
				label: post.title.rendered,
				value: post.link
			} ) );

			setPosts( latest );
		}
		fetchRecentPosts();
	}, [] );

	// Update attributes when a post is selected from search results.
	const selectPost = ( value ) => {
		// `value` is the post URL, so find the corresponding entry in the posts array.
		const post = posts.find( ( post ) => post.value === value );
		if ( ! post ) {
			return;
		}

		setAttributes( {
			postTitle: post.label,
			postUrl: post.value,
		} );
	}

	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Post Settings', 'dmgt' ) }>
						<ComboboxControl
							label={ __( 'Search for a post', 'dmgt' ) }
							placeholder={ __( 'Type to search...', 'dmgt' ) }
							options={ posts }
							onChange={ selectPost }
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>
			<p { ...blockProps }>
				{ postUrl ? (
					<>Read more: <a href={ postUrl }>{ postTitle }</a></>
				) : (
					__( 'No post selected.', 'dmgt' )
				) }
			</p>
		</>
	);
}

/**
 * BLOCK: Dropdown Based Content Container
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType, InnerBlocks, RichText, PlainText } = wp.blocks;// Import registerBlockType() from wp.blocks
const { Component } = wp.element;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'bc-dbc/dbc-container', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'DBC: Container' ), // Block title.
	icon: 'portfolio', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'layout', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.


	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	attributes: {
		title: {
			type: 'string',
			source: 'children',
			selector: 'h2 label',
		},
		placeholder: {
			type: 'string',
			selector: 'input#dbc-combobox',
			attribute: 'placeholder',
			default: 'Search or Select'
		},
		button_text: {
			type: 'string',
			selector: '#dbc-combobox-action',
			default: 'Go!'
		},
		content1_title: {
			type: 'string',
			selector: 'div.option',
		},
		option_titles: {
			source: 'query',
			selector: 'div.listbox div.option',
			query: {
				title: { source: 'text', type: 'string' },
				target: { source: 'attribute', attribute: 'data-target', },
			},

			default: [
				{'title': 'Hello1', 'target': 'stuff1',},
				{'title': 'Hello2', 'target': 'stuff2',},
				{'title': 'Hello3', 'target': 'stuff3',},
				{'title': 'Hello4', 'target': 'stuff4',},
			]
		},
	},
	
	edit: props => {
		const { className, attributes, setAttributes, setFocus, isSelected } = props;
		

		// const focusedEditable = props.focus ? props.focus.editable || 'title' : null;

		const onChangeTitle = value => {
			setAttributes( { title: value } );
		};

		const onChangePlaceholder = value => {
			setAttributes( { placeholder: value } );
		};

		const onChangeButtonText = value => {
			setAttributes( { button_text: value } );
			console.log('no');
		};

		const onChangeOptionTitles = value => {
			setAttributes( { option_titles: value } );
			//console.log('hello');
		}

		/* Option Titles as they display in Edit view */
		/* class OptionTitles extends Component {
			constructor( props ) {
				super( props );
				this.props = props;
			}

			onChangeOptionTitles2 = (value) => {
				
			}

			render() {
				const { value, setAttributes } = this.props;
				
				return (
					value.map((item, i) =>
						<tr key={i}>
							<td><button>X</button></td>
							<td>
								<PlainText
									value={item.title}
									onChange={ value => setAttributes({option_titles: [{title: value }] }) }
							/>
							</td>
							<td><select><option>Select me</option></select></td>
						</tr>
					)
				)
			}
		} */




		return (
			<div className={className + ' panel panel-primary'}>
				<div className='panel-heading'>
					<RichText
						tagName="h2"
						placeholder={ __( '[Enter a Title Here]' ) }
						value={ attributes.title }
						onChange={ onChangeTitle }
						className='panel-title'
						formattingControls={ [] } // hide them
					/>
				</div>
				<div className="panel-body fake-inputs">
					<span className="fake-input">
						<RichText
							tagName="span"
							//placeholder={ __( 'Search or select' ) }
							value={ attributes.placeholder }
							onChange={ onChangePlaceholder }
							formattingControls={ [] } // hide them
						/>
					</span>
					<span className="fake-btn">
						<RichText
							tagName="span"
							// placeholder={ __( 'Go!' ) }
							value={ attributes.button_text }
							onChange={ onChangeButtonText }
							formattingControls={ [] } // hide them
						/>
					</span>
				</div>
				<div className="table-responsive">
					<table className="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									<span className="sr-only">Selected</span>
								</th>
								<th>Title</th>
								<th>Target</th>
							</tr>
						</thead>
						<tbody>
							{
								attributes.option_titles.map( ( item, i ) => {

									function onChangeOptionTitles2(j, value) {
										console.log(j);
										let option_titles = attributes.option_titles;
										console.log(option_titles);
										option_titles.splice(j, 1, { title: value, target: 'replaced!' })
										console.log(option_titles);
										setAttributes({ option_titles: option_titles } );
									}
									return (
										<tr key={i}>
											<td><button>X</button></td>
											<td>
												<PlainText
													value={item.title}
													onChange={onChangeOptionTitles2.bind(this, i)}
												/>
											</td>
											<td><select><option>Select me</option></select></td>
										 </tr>
									)
								})
							}
						</tbody>
					</table>
				</div>
				<div className="panel-body">
					<hr />
					<div className="dbc-block-container">
						<InnerBlocks
							placeholder={__('Content blocks go here!')}
						/>
					</div>
				</div>
			</div>
		);
	},
	save: props => {
		const { className, attributes } = props;

		// Viewing single option
		function DBCListItemSave(props) {
			let { content } = props;
			let output = content.map( ( item, i ) =>
				<div className="option" data-target={ item.target } key={ i } >
					{ item.title }
				</div>

			);
			
			return output;
		}

		return (

			<div className={ className + " dbc panel panel-primary" }>
				<div className="panel-heading">
					<h2 className="panel-title"><label for="dbc-combobox">{ attributes.title }</label></h2>
				</div>

				<div className="panel-body">
					<div className="input-group input-group-lg">
						<div className="combo-wrap">
							<input type="text" className="combobox form-control" id="dbc-combobox" placeholder={ attributes.placeholder } />
							<div className="listbox" aria-labelledby="dbc-combobox">
								
								<DBCListItemSave
									content={ attributes.option_titles }
								/>
								
							</div>
						</div>
						<span className="input-group-btn">
							<button type="button" className="btn btn-default trigger" aria-hidden="true" id="dbc-combobox-trigger">
								<span className="glyphicon glyphicon-menu-down" data-trigger="dbc-combobox"></span>
							</button>
							<button type="button" className="btn btn-success" id="dbc-combobox-action" disabled="disabled">{ attributes.button_text }</button>
						</span>
					</div>
					<hr />
					<InnerBlocks.Content />
				</div>
			</div>
		)
	}
} );

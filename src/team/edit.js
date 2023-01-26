
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { RawHTML } from '@wordpress/element';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { FaFacebookF, FaInstagram, FaTwitter, FaYoutube, FaLinkedin } from 'react-icons/fa';

import './editor.scss';
import imageNoTeamThumbnail from '../cpt/assets/images/noFeaturedImage'

export default function Edit( { attributes, setAttributes } ) {

	const { showBio, showRole, nameTextColor, roleTextColor, bioTextColor, backgroundColor, nameFontSize, fadeAnimationColor  } = attributes;

	const styles = {
		'--name-text-color': nameTextColor,
		'--role-text-color': roleTextColor,
		'--bio-text-color': bioTextColor,
		'--background-color': backgroundColor,
		'--name-font-size': nameFontSize
	}

	const onChangeNameTextColor = ( val ) => {
		    setAttributes( { nameTextColor: val } );
	};
	const onChangeRoleTextColor = ( val ) => {
		    setAttributes( { roleTextColor: val } );
	};
	const onChangeBioTextColor = ( val ) => {
		    setAttributes( { bioTextColor: val } );
	};
	const onChangeBackgroundColor = ( val ) => {
		    setAttributes( { backgroundColor: val } );
	};
	const onChangeFadeAnimationColor = ( val ) => {
		    setAttributes( { fadeAnimationColor: val } );
	};

	const textColorSettingsDropdown = 	[
		{
			label: 'Name Text color',
			value: nameTextColor,
			onChange: onChangeNameTextColor
		},
		showRole && (
			{
				label: 'Role Text Color',
				value: roleTextColor,
				onChange: onChangeRoleTextColor
			}
		),
		showBio && (
		{
			label: 'Bio Text Color',
			value: bioTextColor,
			onChange: onChangeBioTextColor
		}
		)
	]

	const getSocialIcon = (val) => {
		const icons = [
			{
				name: 'social_facebook',
				value: <FaFacebookF size={'1.5rem'} fill={'#fff'} />
			},
			{
				name: 'social_instagram',
				value: <FaInstagram size={'1.5rem'} fill={'#fff'} />
			},
			{
				name: 'social_linkedin',
				value: <FaLinkedin size={'1.5rem'} fill={'#fff'}/>
			},
			{
				name: 'social_twitter',
				value: <FaTwitter size={'1.5rem'} fill={'#fff'} />
			},
			{
				name: 'social_youtube',
				value: <FaYoutube size={'1.5rem'} fill={'#fff'} />
			},
		]
		const result = icons.filter( (icon) => icon.name === val );

		return result[0]['value'];
	}

		const  { teams }  = useSelect( (select) => {

		const teams = select('core').getEntityRecords( 'postType', 'team', {
			'_embed': true,
			'per_page': -1
		} );

		return {
			teams: teams
		}
	}, [] );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Color settings', 'gut-blocks' ) } initialOpen={ false }>
					<PanelColorSettings
							title='Text color'
							colorSettings={ textColorSettingsDropdown }
						/>
					<PanelColorSettings
							title='Background color'
							colorSettings= { [
								{
									label:  __( 'Block background color', 'gut-blocks' ),
									value: backgroundColor,
									onChange: onChangeBackgroundColor
								}
							] }
						/>
				</PanelBody>
				<PanelBody>
					<ToggleControl
						label={ __( 'Hide role', 'gut-blocks' ) }
						checked={  ! showRole }
						onChange={ () => setAttributes( { showRole: ! showRole } ) }
					/>
					<ToggleControl
						label={ __( 'Hide bio', 'gut-blocks' ) }
						checked={ ! showBio }
						onChange={ () => setAttributes( { showBio: ! showBio } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { style: styles }) }>
				<ul className='wp-block-blocks-team__container'>
					{ teams && teams.map( (team) => {
						const { acf } = team;
						const { team_social_links } = acf;

						return (
							<>
							<li key={team.id} className='wp-block-blocks-team__card'>
								<div className='wp-block-blocks-team__image'>
								{ team._embedded && team._embedded['wp:featuredmedia'] && team._embedded['wp:featuredmedia'][0] ?
										( <img
											src={ team._embedded['wp:featuredmedia'][0].source_url }
											alt={ team.title.rendered }

										/> ) :
										( <img
											src={ imageNoTeamThumbnail }
											alt="Team worker"
											width={255}
											height={325}
										/>)
								}
											<div className='wp-block-blocks-team__image__social-links'>
												<ul>
													{ Object.entries(team_social_links).map ((link) => {
														return (
															<li  key={ link[0] } >
																<a href={ link[1] }>{ getSocialIcon(link[0]) }</a>
															</li>
														)
													} )
													}
												</ul>
											</div>
								</div>

								<div className='wp-block-blocks-team__info'>
									{ team.title.rendered ?
										<RawHTML className='wp-block-blocks-team__name'>{ team.title.rendered }</RawHTML> :
										__( 'Default title', 'gut-blocks' )
									}
									{ team.acf && team.acf.team_role && showRole && (
										<RawHTML className='wp-block-blocks-team__role'> { team.acf.team_role } </RawHTML>
									) }
									{ team.content && team.content.rendered && showBio && (
										<RawHTML className='wp-block-blocks-team__bio'> { team.content.rendered } </RawHTML>
									) }
								</div>

							</li>
						</>
						)
					})}
				</ul>
			</div>
		</>
	);
}

<?php
/**
 * Asha Feeds Theme Page
 *
 * @package Asha Feeds
 */

function ashafeeds_admin_scripts() {
	wp_dequeue_script('jquery-superfish');
	wp_dequeue_script('ashafeeds-custom-scripts');
}
add_action( 'admin_enqueue_scripts', 'ashafeeds_admin_scripts' );

if ( ! defined( 'ashafeeds_FREE_THEME_URL' ) ) {
	define( 'ashafeeds_FREE_THEME_URL', 'https://www.themespride.com/themes/free-automobile-wordpress-theme/' );
}
if ( ! defined( 'ashafeeds_PRO_THEME_URL' ) ) {
	define( 'ashafeeds_PRO_THEME_URL', 'https://www.themespride.com/themes/automobile-wordpress-theme/' );
}
if ( ! defined( 'ashafeeds_DEMO_THEME_URL' ) ) {
	define( 'ashafeeds_DEMO_THEME_URL', 'https://www.themespride.com/ashafeeds-pro/' );
}
if ( ! defined( 'ashafeeds_DOCS_THEME_URL' ) ) {
    define( 'ashafeeds_DOCS_THEME_URL', 'https://www.themespride.com/demo/docs/ashafeeds-lite/' );
}
if ( ! defined( 'ashafeeds_RATE_THEME_URL' ) ) {
    define( 'ashafeeds_RATE_THEME_URL', 'https://wordpress.org/support/theme/ashafeeds/reviews/#new-post' );
}
if ( ! defined( 'ashafeeds_CHANGELOG_THEME_URL' ) ) {
    define( 'ashafeeds_CHANGELOG_THEME_URL', get_template_directory() . '/readme.txt' );
}
if ( ! defined( 'ashafeeds_SUPPORT_THEME_URL' ) ) {
    define( 'ashafeeds_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/ashafeeds/' );
}

/**
 * Add theme page
 */
function ashafeeds_menu() {
	add_theme_page( esc_html__( 'About Theme', 'ashafeeds' ), esc_html__( 'About Theme', 'ashafeeds' ), 'edit_theme_options', 'ashafeeds-about', 'ashafeeds_about_display' );
}
add_action( 'admin_menu', 'ashafeeds_menu' );

/**
 * Display About page
 */
function ashafeeds_about_display() {
	$ashafeeds_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $ashafeeds_theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$ashafeeds_description = explode( '. ', $ashafeeds_theme->get( 'Description' ) );

					array_pop( $ashafeeds_description );

					$ashafeeds_description = implode( '. ', $ashafeeds_description );

					echo esc_html( $ashafeeds_description . '.' );
				?></p>
				<p class="actions">
					<a target="_blank" href="<?php echo esc_url( ashafeeds_FREE_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'ashafeeds' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( ashafeeds_DEMO_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View Demo', 'ashafeeds' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( ashafeeds_DOCS_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Instructions', 'ashafeeds' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( ashafeeds_RATE_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Rate this theme', 'ashafeeds' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( ashafeeds_PRO_THEME_URL ); ?>" class="green button button-secondary" target="_blank"><?php esc_html_e( 'Upgrade to pro', 'ashafeeds' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $ashafeeds_theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'ashafeeds' ); ?>">
			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ashafeeds-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'ashafeeds-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'ashafeeds' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ashafeeds-about', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Compare free Vs Pro', 'ashafeeds' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ashafeeds-about', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Changelog', 'ashafeeds' ); ?></a>
		</nav>

		<?php
			ashafeeds_main_screen();

			ashafeeds_changelog_screen();

			ashafeeds_free_vs_pro();
		?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'ashafeeds' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'ashafeeds' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'ashafeeds' ) : esc_html_e( 'Go to Dashboard', 'ashafeeds' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function ashafeeds_main_screen() {
	if ( isset( $_GET['page'] ) && 'ashafeeds-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'ashafeeds' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'ashafeeds' ) ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'ashafeeds' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'ashafeeds' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'ashafeeds' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( ashafeeds_SUPPORT_THEME_URL ); ?>" class="button button-primary"><?php esc_html_e( 'Support Forum', 'ashafeeds' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Upgrade To Premium With Straight 20% OFF.', 'ashafeeds' ); ?></h2>
				<p><?php esc_html_e( 'Get our amazing WordPress theme with exclusive 20% off use the coupon', 'ashafeeds' ) ?>"<input type="text" value="GETPro20" id="myInput">".</p>
				<button class="button button-primary" onclick="ashafeeds_text_copyied()"><?php esc_html_e( 'GETPro20', 'ashafeeds' ); ?></button>
			</div>
		</div>
	<?php
	}
}

/**
 * Output the changelog screen.
 */
function ashafeeds_changelog_screen() {
	if ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) {
		global $wp_filesystem;
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'ashafeeds' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'ashafeeds_changelog_file', ashafeeds_CHANGELOG_THEME_URL );
				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = ashafeeds_parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
	<?php
	}
}

/**
 * Parse changelog from readme file.
 * @param  string $content
 * @return string
 */
function ashafeeds_parse_changelog( $content ) {
	// Explode content with ==  to juse separate main content to array of headings.
	$content = explode ( '== ', $content );

	$changelog_isolated = '';

	// Get element with 'Changelog ==' as starting string, i.e isolate changelog.
	foreach ( $content as $key => $value ) {
		if (strpos( $value, 'Changelog ==') === 0) {
	    	$changelog_isolated = str_replace( 'Changelog ==', '', $value );
	    }
	}

	// Now Explode $changelog_isolated to manupulate it to add html elements.
	$changelog_array = explode( '= ', $changelog_isolated );

	// Unset first element as it is empty.
	unset( $changelog_array[0] );

	$changelog = '<pre class="changelog">';

	foreach ( $changelog_array as $value) {
		// Replace all enter (\n) elements with </span><span> , opening and closing span will be added in next process.
		$value = preg_replace( '/\n+/', '</span><span>', $value );

		// Add openinf and closing div and span, only first span element will have heading class.
		$value = '<div class="block"><span class="heading">= ' . $value . '</span></div>';

		// Remove empty <span></span> element which newr formed at the end.
		$changelog .= str_replace( '<span></span>', '', $value );
	}

	$changelog .= '</pre>';

	return wp_kses_post( $changelog );
}

/**
 * Import Demo data for theme using catch themes demo import plugin
 */
function ashafeeds_free_vs_pro() {
	if ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'View Free vs Pro Table below:', 'ashafeeds' ); ?></p>
			<div class="vs-theme-table">
				<table>
					<thead>
						<tr><th scope="col"></th>
							<th class="head" scope="col"><?php esc_html_e( 'Free Theme', 'ashafeeds' ); ?></th>
							<th class="head" scope="col"><?php esc_html_e( 'Pro Theme', 'ashafeeds' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><span><?php esc_html_e( 'Theme Demo Set Up', 'ashafeeds' ); ?></span></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Templates, Color options and Fonts', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Included Demo Content', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Section Ordering', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Multiple Sections', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Plugins', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Premium Technical Support', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Access to Support Forums', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Free updates', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Unlimited Domains', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Responsive Design', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Live Customizer', 'ashafeeds' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td class="feature feature--empty"></td>
							<td class="feature feature--empty"></td>
							<td headers="comp-2" class="td-btn-2"><a class="sidebar-button single-btn" href="<?php echo esc_url(ashafeeds_PRO_THEME_URL);?>"><?php esc_html_e( 'Go for Premium', 'ashafeeds' ); ?></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}
}

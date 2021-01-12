<?php
/* --------------------------------------------------------------
WP CUSTOMIZE SECTION - CUSTOM SETTINGS
-------------------------------------------------------------- */

add_action( 'customize_register', 'weride_customize_register' );

function weride_customize_register( $wp_customize ) {

    /* SOCIAL SETTINGS */
    $wp_customize->add_section('wrd_social_settings', array(
        'title'    => __('Redes Sociales', 'weride'),
        'description' => __('Agregue aqui las redes sociales de la página, serán usadas globalmente', 'weride'),
        'priority' => 175,
    ));

    $wp_customize->add_setting('wrd_social_settings[facebook]', array(
        'default'           => '',
        'sanitize_callback' => 'weride_sanitize_url',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( 'facebook', array(
        'type' => 'url',
        'section' => 'wrd_social_settings',
        'settings' => 'wrd_social_settings[facebook]',
        'label' => __( 'Facebook', 'weride' ),
    ));

    $wp_customize->add_setting('wrd_social_settings[twitter]', array(
        'default'           => '',
        'sanitize_callback' => 'weride_sanitize_url',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( 'twitter', array(
        'type' => 'url',
        'section' => 'wrd_social_settings',
        'settings' => 'wrd_social_settings[twitter]',
        'label' => __( 'Twitter', 'weride' ),
    ));

    $wp_customize->add_setting('wrd_social_settings[instagram]', array(
        'default'           => '',
        'sanitize_callback' => 'weride_sanitize_url',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',

    ));

    $wp_customize->add_control( 'instagram', array(
        'type' => 'url',
        'section' => 'wrd_social_settings',
        'settings' => 'wrd_social_settings[instagram]',
        'label' => __( 'Instagram', 'weride' ),
    ));

    $wp_customize->add_setting('wrd_social_settings[linkedin]', array(
        'default'           => '',
        'sanitize_callback' => 'weride_sanitize_url',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( 'linkedin', array(
        'type' => 'url',
        'section' => 'wrd_social_settings',
        'settings' => 'wrd_social_settings[linkedin]',
        'label' => __( 'LinkedIn', 'weride' ),
    ));

    $wp_customize->add_setting('wrd_social_settings[youtube]', array(
        'default'           => '',
        'sanitize_callback' => 'weride_sanitize_url',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',

    ));

    $wp_customize->add_control( 'youtube', array(
        'type' => 'url',
        'section' => 'wrd_social_settings',
        'settings' => 'wrd_social_settings[youtube]',
        'label' => __( 'YouTube', 'weride' ),
    ) );

    /* COOKIES SETTINGS */
    $wp_customize->add_section('wrd_cookie_settings', array(
        'title'    => __('Cookies', 'weride'),
        'description' => __('Opciones de Cookies', 'weride'),
        'priority' => 176,
    ));

    $wp_customize->add_setting('wrd_cookie_settings[cookie_text]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'edit_theme_options',
        'type'           => 'option'

    ));

    $wp_customize->add_control( 'cookie_text', array(
        'type' => 'textarea',
        'label'    => __('Cookie consent', 'weride'),
        'description' => __( 'Texto del Cookie consent.' ),
        'section'  => 'wrd_cookie_settings',
        'settings' => 'wrd_cookie_settings[cookie_text]'
    ));

    $wp_customize->add_setting('wrd_cookie_settings[cookie_link]', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',

    ));

    $wp_customize->add_control( 'cookie_link', array(
        'type'     => 'dropdown-pages',
        'section' => 'wrd_cookie_settings',
        'settings' => 'wrd_cookie_settings[cookie_link]',
        'label' => __( 'Link de Cookies', 'weride' ),
    ) );

}

function weride_sanitize_url( $url ) {
    return esc_url_raw( $url );
}

/* --------------------------------------------------------------
CUSTOM CONTROL PANEL
-------------------------------------------------------------- */
/*
function register_weride_settings() {
    register_setting( 'weride-settings-group', 'monday_start' );
    register_setting( 'weride-settings-group', 'monday_end' );
    register_setting( 'weride-settings-group', 'monday_all' );
}

add_action('admin_menu', 'weride_custom_panel_control');

function weride_custom_panel_control() {
    add_menu_page(
        __( 'Panel de Control', 'weride' ),
        __( 'Panel de Control','weride' ),
        'manage_options',
        'weride-control-panel',
        'weride_control_panel_callback',
        'dashicons-admin-generic',
        120
    );
    add_action( 'admin_init', 'register_weride_settings' );
}

function weride_control_panel_callback() {
    ob_start();
?>
<div class="weride-admin-header-container">
    <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="weride" />
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
</div>
<form method="post" action="options.php" class="weride-admin-content-container">
    <?php settings_fields( 'weride-settings-group' ); ?>
    <?php do_settings_sections( 'weride-settings-group' ); ?>
    <div class="weride-admin-content-item">
        <table class="form-table">
            <tr valign="center">
                <th scope="row"><?php _e('Monday', 'weride'); ?></th>
                <td>
                    <label for="monday_start">Starting Hour: <input type="time" name="monday_start" value="<?php echo esc_attr( get_option('monday_start') ); ?>"></label>
                    <label for="monday_end">Ending Hour: <input type="time" name="monday_end" value="<?php echo esc_attr( get_option('monday_end') ); ?>"></label>
                    <label for="monday_all">All Day: <input type="checkbox" name="monday_all" value="1" <?php checked( get_option('monday_all'), 1 ); ?>></label>
                </td>
            </tr>
        </table>
    </div>
    <div class="weride-admin-content-submit">
        <?php submit_button(); ?>
    </div>
</form>
<?php
    $content = ob_get_clean();
    echo $content;
}
*/

<?php

function osdi_add_admin_menu()
{

    add_options_page('OSDI Signup', 'OSDI Signup', 'manage_options', 'osdi_signup', 'osdi_options_page');

}


function osdi_settings_init()
{

    register_setting('pluginPage', 'osdi_settings');

    add_settings_field(
        'osdi_textarea_field_2',
        __('YAML Service Config', 'osdi'),
        'osdi_textarea_field_2_render',
        'pluginPage',
        'osdi_pluginPage_section'
    );

    add_settings_section(
        'osdi_pluginPage_section',
        __('Settings', 'osdi'),
        'osdi_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'osdi_select_field_logging',
        __( 'Logging', 'osdi' ),
        'osdi_select_field_logging_render',
        'pluginPage',
        'osdi_pluginPage_section'
    );

    /*
    add_settings_field(
        'osdi_text_field_0',
        __('Log File', 'osdi'),
        'osdi_text_field_0_render',
        'pluginPage',
        'osdi_pluginPage_section'
    );

    add_settings_field(
        'osdi_text_field_3',
        __('Notification Email Address', 'osdi'),
        'osdi_text_field_3_render',
        'pluginPage',
        'osdi_pluginPage_section'
    );

    add_settings_field(
        'osdi_text_field_4',
        __('Settings field description', 'osdi'),
        'osdi_text_field_4_render',
        'pluginPage',
        'osdi_pluginPage_section'
    );
*/

}


function osdi_textarea_field_2_render()
{

    $options = osdi_get_options();
    ?>
    <textarea style='font-family: monospace' cols='80' rows='25'
              name='osdi_settings[osdi_textarea_field_2]'><?php echo $options['osdi_textarea_field_2']; ?></textarea>
    <?php

}


function osdi_select_field_logging_render(  ) {

    $options = osdi_get_options();
    ?>
    <select name='osdi_settings[osdi_select_field_logging]'>
        <option value='Enabled' <?php selected( $options['osdi_select_field_logging'], 'Enabled' ); ?>>Enabled</option>
        <option value='Disabled' <?php selected( $options['osdi_select_field_logging'], 'Disabled' ); ?>>Disabled</option>
    </select>
    <p>See wp-content/osdi/osdi.log</p>
    <pre><?php
        echo tailCustom(osdi_log_file(), 10);
        ?>
    </pre>
    <?php

}

/*
 *
function osdi_text_field_0_render()
{

    $options = osdi_get_options();
    ?>
    <input type='text' name='osdi_settings[osdi_text_field_0]' value='<?php echo $options['osdi_text_field_0']; ?>'>
    <?php

}

function osdi_text_field_3_render()
{

    $options = osdi_get_options();
    ?>
    <input type='text' name='osdi_settings[osdi_text_field_3]' value='<?php echo $options['osdi_text_field_3']; ?>'>
    <?php

}


function osdi_text_field_4_render()
{

    $options = osdi_get_options();
    ?>
    <input type='text' name='osdi_settings[osdi_text_field_4]' value='<?php echo $options['osdi_text_field_4']; ?>'>

    <?php

}

*/
function osdi_settings_section_callback()
{

    echo __('Configure OSDI services', 'osdi');

}


function osdi_options_page()
{

    ?>
    <form action='options.php' method='post'>

        <h2>OSDI Signup</h2>

        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>

    </form>
    <?php

}

?>
<?php

add_action('admin_menu', 'osdi_add_admin_menu');
add_action('admin_init', 'osdi_settings_init');

function osdi_add_admin_menu()
{

    add_menu_page('OSDI Signup', 'OSDI Signup', 'manage_options', 'osdi_signup', 'osdi_options_page', 'dashicons-migrate');
    add_submenu_page('osdi_signup', 'Servers', 'Servers', 'manage_options', 'osdi_signup', 'osdi_options_page');
    add_submenu_page('osdi_signup', 'Logging', 'Logging', 'manage_options', 'osdi_logging_settings', 'osdi_logging_page');
    add_submenu_page('osdi_signup', 'Help', 'Help', 'manage_options', 'osdi_help_settings', 'osdi_help_page');
}


function osdi_settings_init()
{

    register_setting('pluginPage', 'osdi_settings');
    register_setting('pluginPageLogging', 'osdi_logging');

    add_settings_field(
        'osdi_settings_servers',
        __('YAML Service Config', 'osdi'),
        'osdi_settings_servers_render',
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
        'osdi_settings_logging',
        __('Logging', 'osdi'),
        'osdi_settings_logging_render',
        'pluginPageLogging',
        'osdi_pluginPage_section_logging'
    );

    add_settings_section(
        'osdi_pluginPage_section_logging',
        __('Logging Settings', 'osdi'),
        'osdi_settings_section_logging_callback',
        'pluginPageLogging'
    );

}


function osdi_settings_servers_render()
{

    $options = osdi_get_options();
    ?>
    <textarea style='font-family: monospace' cols='80' rows='25'
              name='osdi_settings[osdi_settings_servers]'><?php echo $options['osdi_settings_servers']; ?></textarea>
    <?php

}


function osdi_settings_logging_render()
{

    $options = osdi_get_options();
    ?>
    <select name='osdi_settings[osdi_settings_logging]'>
        <option value='Enabled' <?php selected($options['osdi_settings_logging'], 'Enabled'); ?>>Enabled</option>
        <option value='Disabled' <?php selected($options['osdi_settings_logging'], 'Disabled'); ?>>Disabled</option>
    </select>

    <?php

}

function osdi_settings_section_callback()
{

    echo __('Configure OSDI services', 'osdi');

}

function osdi_settings_logging_section_callback()
{
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

function osdi_logging_page()
{

    ?>
    <form action='options.php' method='post'>


        <h2>Latest Activity</h2>

        <p>See wp-content/osdi/osdi.log</p>
    <pre><?php
        echo tailCustom(osdi_log_file(), 20);
        ?>
    </pre>
        <?php
        //settings_fields('pluginPageLogging');
        do_settings_sections('pluginPageLogging');
        submit_button();
        ?>
    </form>
    <?php

}


function osdi_help_page()
{

    $html = <<<HTML

 <form id="osdi-signup" method="POST" action="/"> <!-- action is the current page -->

     <input type="text" placeholder="Given Name" class="text name" name="osdi-given-name">
     <input type="text" placeholder="Family Name" class="text name" name="osdi-family-name">
     <input type="text" placeholder="Email" class="text email" name="osdi-email" required>
     <input type="text" placeholder="Postal Code" class="text" name="osdi-postal-code" required>
     <input type="submit" value="Join Us" class="submit">
 </form>
HTML;

    ?>

    <h1>Help</h1>

    <h2>Example signup form HTML</h2>
    <p>Construct your HTML form according to your liking. Name the field values accordingly:</p>
    <pre>
        <?php echo htmlentities($html); ?>
    </pre>

    <h2>OSDI</h2>
    <img src="<?php echo plugins_url('osdi.square.png', __FILE__) ?>">
    <p>More information about OSDI can be found at <a href="http://opensupporter,.org">opensupporter.org</a></p>

    <h2>YAML</h2>
    <p>Lean more about YAML syntax at <a href="http://www.yaml.org/start.html">http://www.yaml.org/start.html</a></p>
    <?php

}

?>
<?php
/**
 * Plugin Name: Open Supporter Data Interface (OSDI) Signup form
 * Plugin URI: https://github.com/opensupporter/wp-osdi-signup
 *
 * Description: Allows supporter signups to be enhanced and go to multiple CRMs via OSDI.
 * Version: 0.5
 * Author: Josh Cohen
 * Author URI: http://opensupporter.org
 * License: MIT
 */

require_once('config.php');
require_once('spyc.php');
require_once('utils.php');
require_once('settings.php');



add_action('wp_head', 'osdi_init');
add_action( 'admin_menu', 'osdi_add_admin_menu' );
add_action( 'admin_init', 'osdi_settings_init' );

function osdi_init()
{
    global $osdi_config;
    $options=get_option('osdi_settings');
    $osdi_config=spyc_load($options['osdi_textarea_field_2']);

    if (isset($_POST['osdi-email'])) {

        $signup = osdi_process_form();
        $signup['originating_system']= $osdi_config['originating_system'];
        $status = osdi_loop($signup);
//        $status=osdi_process_form();
        $redirect_url = $status ? $osdi_config['redirect']['success_url'] :
            $osdi_config['redirect']['fail_url'];

        if ( $redirect_url == 'none') {
            osdi_log('No Redirect. Set to: ' . $redirect_url);
        } else {
            osdi_log('Redirecting to: ' . $redirect_url);
            wp_redirect($redirect_url);
        }

    }
}

function osdi_process_form()
{
    $given_name = osdi_nav($_POST['osdi-given-name']);
    $family_name = osdi_nav($_POST['osdi-family-name']);
    $email = osdi_nav($_POST['osdi-email']);

    $postal_code = osdi_nav($_POST['osdi-postal-code']);
    $address1 = osdi_nav($_POST['osdi-address1']);
    $address2 = osdi_nav($_POST['osdi-address2']);
    $locality = osdi_nav($_POST['osdi-locality']);
    $region = osdi_nav($_POST['osdi-region']);
    $phone = osdi_nav($_POST['osdi-phone']);

    $osdi_signup = array(
        "originating_system" => "wp-osdi-signup",
        "person" => array(
            "given_name" => $given_name,
            "family_name" => $family_name,
            "email_addresses" => array(
                array(
                    "address" => $email

                )
            ),
            "phone_numbers" => array(
                array(
                    "number" => $phone,
                )
            ),
            "postal_addresses" => array(
                array(
                    "address_lines" => array(
                        $address1, $address2
                    ),
                    "locality" => $locality,
                    "region" => $region,
                    "postal_code" => $postal_code,
                )
            )
        )

    );

    return $osdi_signup;
}


function osdi_loop($signup)
{
    global $osdi_config;

    $enhanced = false;


    $servers = $osdi_config['servers'];

    foreach ($servers as $server) {
        if ($server['enabled']) {
            $url = $server['url'];
            $api_token = $server['api_token'];
           osdi_log("Processing signup server " . $server['name'] . " @ " . $url);
           osdi_log("Api token ..." . substr($api_token, -8));
            if ( $server['data'] ) {
                $result_obj=$server['data'];

            } else {
                $result=osdi_request($url, json_encode(osdi_prune($signup)), $api_token);
                $result_obj=json_decode($result,true);
            }
            if ($server['mode'] == 'enhancer' ) {
                #TODO clean links and mebedded

                $signup['person']=MergeArrays($signup['person'],$result_obj);
               osdi_log("merged");
            }

        }

    }

    # TODO
    # check primary status and return false if it fails
    # merge enhanced with existing to handle tagging
    return true;
}

function osdi_request($url, $json, $api_token)
{
    $ch = curl_init($url);
    # Setup request to send json via POST.
    $payload = $json;

   osdi_log($json);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/wp-content/plugins/wp-osdi-signup/cacert.pem");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'OSDI-API-Token: ' . $api_token));

    # Return response instead of printing.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    # Send request.
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    $status = $info['http_code'];

   osdi_log("Status Code: " . $info['http_code']);
    if ($result == false || $status > 399) {
       osdi_log("ERROR Curl Status: " . curl_error($ch));
       osdi_log($result);
        $result = false;

    }

    curl_close($ch);


    return $result;
}
?>



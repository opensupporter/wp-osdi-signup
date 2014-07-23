<?php
/**
 * Plugin Name: Open Supporter Data Interface (OSDI) Signup form
 * Plugin URI: https://github.com/opensupporter/wp-osdi-signup
 *
 * Description: Allows supporter signups to go to multiple CRMs via OSDI.
 * Version: 0.2
 * Author: Josh Cohen
 * Author URI: http://osdi.io
 * License: Mozilla
 */
error_reporting(E_ALL & ~E_NOTICE);

require_once('config.php');
// misc utilities
if (!function_exists('_log')) {
    function _log($message)
    {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            } else {
                error_log($message);
            }
        }
    }
}


add_action('template_redirect', 'osdi_init');

function osdi_init()
{
    global $osdi_config;

    if ((is_single() || is_page()) && $_POST['osdi-email']) {

        $signup = osdi_process_form();
        $signup['originating_system']= $osdi_config['originating_system'];
        $status = osdi_loop($signup);
//        $status=osdi_process_form();
        $redirect_url = $status ? $osdi_config['redirect']['success_url'] :
            $osdi_config['redirect']['fail_url'];
        _log('Redirecting to: ' . $redirect_url);
        wp_redirect($redirect_url);
    }
}

function osdi_nav($obj) {

    $val = $obj;
    if ($val == null ) {
        $val = '';
    }
    return $val;

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

function osdi_loop($signup_obj)
{
    global $osdi_config;

    $enhanced = false;
    $signup = json_encode($signup_obj);

    $enhancer = $osdi_config['enhancer'];
    if ($enhancer['enabled']) {
        $en_url = $enhancer['url'];
        $en_api_token = $enhancer['api_token'];
        _log("Using ehnancer " . $en_url);
        $enhanced = osdi_request($en_url, $signup, $en_api_token);
        if ($enhanced != false) {
            $signup = $enhanced;
            _log("Successful enhance, using that");
        } else {
            _log("Enhancer Error");
        }
    } else {
        _log("No Enhancer");
    }


    $servers = $osdi_config['servers'];

    foreach ($servers as $server) {
        if ($server['enabled']) {
            $url = $server['url'];
            $api_token = $server['api_token'];
            _log("Processing signup server " . $server['name'] . " @ " . $url);
            _log("Api token ..." . substr($api_token, -8));
            osdi_request($url, $signup, $api_token);
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

    _log($json);
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

    _log("Status Code: " . $info['http_code']);
    if ($result == false || $status > 399) {
        _log("ERROR Curl Status: " . curl_error($ch));
        _log($result);
        $result = false;

    }

    curl_close($ch);


    return $result;
}


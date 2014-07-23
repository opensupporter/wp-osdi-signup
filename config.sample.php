<?php
/**
 *
 * Author: Josh Cohen, Open Supporter Data Interface
 *
 */


$osdi_config = array(
    //
    // A list of OSDI server endpoints to push signup information to
    // Contact your vendor to obtain the relevant OSDI endpoint and credentials.
    //
    "servers" => array(
        array(
            "name" => "Salsa",
            "url" => "http://salsaosdi/proxy/salsa/person_signup_helper",
            "api_token" => "<API-TOKEN>",
            "enabled" => true
        ),
        array(
            "name" => "VAN",
            "url" => "http://vanosdi/proxy/van/person_signup_helper",
            "api_token" => "<API-TOKEN>",
            "enabled" => true
        ),
        array(
            "name" => "BroadStripes",
            "url" => "https://crm.broadstripes.com/api/osdi/person_signup_helper",
            "api_token" => "<API-TOKEN>",
            "enabled" => true
        )
    ),
    "redirect" => array(
        // Where to redirect the browser after submission
        "success_url" => "http://localhost:3000/api/v1",
        "fail_url" => "http://localhost/"
    ),
    //
    // EXPERIMENTAL
    // An optional enhancer service.  Before pushing signups into CRMs, first call the enhancer to get mode data
    //
    "enhancer" => array(
        "name" => "TargetSmart / Catalist",
        "url" => "http://tscat/proxy/tscat/enhance",
        "api_token" => "<API-TOKEN>",
        "enabled" => true
    ),
    # This can be changed to indicate which system signups are coming from, ie "XYZ website"
    # if supported on your backend system.
    "originating_system" => "wp-osdi-signup"

);
?>

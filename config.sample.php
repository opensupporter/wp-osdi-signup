<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Josh
 * Date: 7/12/14
 * Time: 12:08 PM
 * To change this template use File | Settings | File Templates.
 */


$osdi_config = array(
    // An optional enhancer service.  Before pushing signups into CRMs, first call the enhancer to get mode data
    "enhancer" => array(
        "name" => "TargetSmart / Catalist",
        "url" => "http://tscat/proxy/tscat/enhance",
        "api_token" => "<API-TOKEN>"
    ),
    // A list of OSDI server endpoints to push signup information to
    "servers" => array(
        array(
            "name" => "Salsa",
            "url" => "http://salsaosdi/proxy/salsa/person_signup_helper",
            "api_token" => "<API-TOKEN>"
        ),
        array(
            "name" => "VAN",
            "url" => "http://vanosdi/proxy/van/person_signup_helper",
            "api_token" => "<API-TOKEN>"
        ),
        array(
            "name" => "BroadStripes",
            "url" => "https://crm.broadstripes.com/api/osdi/person_signup_helper",
            "api_token" => "<API-TOKEN>"
        )
    )

);
?>

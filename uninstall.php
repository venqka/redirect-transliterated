<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$rt_option = 'redirection_status';

delete_option( $rt_option );
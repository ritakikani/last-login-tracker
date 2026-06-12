<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option(
	'wpll_settings'
);

$users = get_users(
	array(
		'fields' => 'ids',
	)
);

foreach ( $users as $user_id ) {

	delete_user_meta(
		$user_id,
		'wpll_last_login'
	);

	delete_user_meta(
		$user_id,
		'wpll_last_login_ip'
	);
}
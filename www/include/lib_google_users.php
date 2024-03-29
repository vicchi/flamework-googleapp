<?php

#################################################################

function google_users_create_user ($user) {
	$hash = array ();

	foreach ($user as $k => $v) {
		$hash[$k] = AddSlashes ($v);
	}

	$rsp = db_insert ('GoogleUsers', $hash);

	if (!$rsp['ok']) {
		return null;
	}

	$cache_key = "google_user_{$user['google_id']}";
	cache_set ($cache_key, $user, "cache locally");

	$cache_key = "google_user_{$user['id']}";
	cache_set ($cache_key, $user, "cache locally");

	return $user;
}

#################################################################

function google_users_update_user (&$google_user, $update) {
	$hash = array ();
		
	foreach ($update as $k => $v) {
		$hash[$k] = AddSlashes ($v);
	}

	$enc_id = AddSlashes ($google_user['user_id']);
	$where = "user_id='{$enc_id}'";

	$rsp = db_update ('GoogleUsers', $hash, $where);

	if ($rsp['ok']) {
		$google_user = array_merge ($google_user, $update);

		$cache_key = "google_user_{$google_user['google_id']}";
		cache_unset ($cache_key);

		$cache_key = "google_user_{$google_user['user_id']}";
		cache_unset ($cache_key);
	}

	return $rsp;
}

#################################################################

function google_users_get_by_google_id ($google_id) {
	$cache_key = "google_user_{$google_id}";
	$cache = cache_get ($cache_key);

	if ($cache['ok']){
		return $cache['data'];
	}

	$enc_google_id = AddSlashes ($google_id);

	$sql = "SELECT * FROM GoogleUsers WHERE google_id='{$enc_google_id}'";
	$rsp = db_fetch ($sql);
	$user = db_single ($rsp);

	cache_set ($cache_key, $user, "cache locally");

	return $user;
}

#################################################################

function google_users_get_by_user_id ($user_id) {
	$cache_key = "google_user_{$user_id}";
	$cache = cache_get ($cache_key);

	if ($cache['ok']) {
		return $cache['data'];
	}

	$enc_id = AddSlashes ($user_id);

	$sql = "SELECT * FROM GoogleUsers WHERE user_id='{$enc_id}'";

	$rsp = db_fetch ($sql);
	$user = db_single ($rsp);

	cache_set ($cache_key, $user, "cache locally");

	return $user;
}

#################################################################

?>

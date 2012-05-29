flamework-googleapp
--

These are drop-in pages (and libraries) for Flamework so that all authentication and login magic is handled using the Google OAuth2 API as a single sign-on provider. It works (for me), but the documentation is minimal and it's still a work-in-progress. Expect fun and games (and bugs).

Installation
--

* Grab the source and put it somewhere
* Configure your Flamework powered site for Google OAuth2 in the [Google APIs Console](https://code.google.com/apis/console/)
* Run [bin/setup.sh](https://github.com/vicchi/flamework-googleapp/blob/master/bin/setup.sh), passing as a parameter to path to the root of your Flamework install
* Copy the contents of [www/include/config.php.example](https://github.com/vicchi/flamework-googleapp/blob/master/bin/setup.sh) into `<flamework-root>/www/include/config.php`

	# Google OAuth2 stuff
	# Configure these from the values you got back from the Google APIs Console
	# (https://code.google.com/apis/console/)
	
	# Stuff you will 100% want to configure; you'll get the Client ID and the Client
	# Secret from the Google APIs Console when you create a new Project and generate
	# OAuth2 credentials - see https://code.google.com/apis/console

	$GLOBALS['cfg']['google_oauth2_client_id'] = '';
	$GLOBALS['cfg']['google_oauth2_client_secret'] = '';

	# Stuff you'll probably want to configure; this is the bare-bones scope needed to
	# actually authenticate with Google via OAuth2. Take a look at the OAuth 2.0 Playground
	# - https://code.google.com/oauthplayground/ - for a reasonably complete list

	$GLOBALS['cfg']['google_oauth2_scope'] = 'https://www.googleapis.com/auth/userinfo.profile';
	
	# Stuff you probably won't want to configure
	
	$GLOBALS['cfg']['google_oauth2_access_type'] = 'offline';
	$GLOBALS['cfg']['google_oauth2_approval'] = 'auto';

	# Stuff you shouldn't configure unless you're using custom callback code
	
	$GLOBALS['cfg']['google_oauth2_redirect_uri'] = 'auth_callback_google_oauth2.php';

* You'll want to adjust your page templates to use `signin_google_oauth2.php` as your signin link and probably do some `.htaccess` magic as well
* Look in `schema/alters` in your Flamework root to see the database table setup stuff you'll need to add into your database, either via the `mysql` command or via phpMyAdmin.

That's it. Or should be. If I've forgotten something (possible) or there's a bug (probable), please let me know or submit a pull request.

To Do
--

* Add code to allow basic Google OAuth2-ness without also having to create a new database user.
* Add code to allow Google OAuth2 authentication to be added to an existing database user; in other words, to allow multiple OAuth'd API access from a single database user's account and not just as SSO

See Also
--

* [Aaron's fork of flamework](https://github.com/straup/flamework)

See Also Also

* [The original flamework](https://github.com/exflickr/flamework)
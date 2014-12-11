<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
		"base_url" => "http://ec2-54-225-94-8.compute-1.amazonaws.com/hybridauth",

		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => true
			),

			"Yahoo" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"AOL"  => array ( 
				"enabled" => true 
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "384214192707-g29fuil7tg06h7cqd0qh07a8fnpfbe0g.apps.googleusercontent.com", "secret" => "6M_XnqY4_24nxMnTgvXfjX1p" ),
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "1421667988106410", "secret" => "6e86c52fcdf52236df43749880c3fe3a" ),
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			// windows live
			"Live" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"MySpace" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "75w260sq3lqfmz", "secret" => "uwLIMAcXnoODANOi" )
			),

			"Foursquare" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => "",
	);

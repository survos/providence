<?php
define("__CA_APP_TYPE__", "PROVIDENCE");
define("__CA_MICROTIME_START_OF_REQUEST__", microtime());
define("__CA_BASE_MEMORY_USAGE__", memory_get_usage(true));
define("__CA_BASE_DIR__", __DIR__ . '/..');

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';
(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();

require(__DIR__ . "/../app/helpers/errorHelpers.php");

$setup = __DIR__ . '/../setup.php';
assert(file_exists($setup), $setup . ' is missing.');
require_once($setup);

require_once(__DIR__ . '/../app/helpers/post-setup.php');


$response = $kernel->handle($request);
if ($response->getStatusCode() === 404) {
//	handleLegacy();
} else {
	$response->send();
	$kernel->terminate($request, $response);
}


// copied from index.php, mostly to set paths

//function handleLegacy()
{




	// connect to database
		$o_db = new Db(null, null, false);
		if (!$o_db->connected()) {
			$opa_error_messages = array("Could not connect to database. Check your database configuration in <em>setup.php</em>.");
			require_once(__CA_BASE_DIR__."/themes/default/views/system/configuration_error_html.php");
			exit();
		}
		//
		// do a sanity check on application and server configuration before servicing a request
		//
		require_once(__CA_APP_DIR__.'/lib/ConfigurationCheck.php');
		ConfigurationCheck::performQuick();
		if(ConfigurationCheck::foundErrors()){
			if (defined('__CA_ALLOW_AUTOMATIC_UPDATE_OF_DATABASE__') && __CA_ALLOW_AUTOMATIC_UPDATE_OF_DATABASE__ && $_REQUEST['updateSchema']) {
				ConfigurationCheck::updateDatabaseSchema();
			} else {
				ConfigurationCheck::renderErrorsAsHTMLOutput();
			}
			exit();
		}

		if(isset($_REQUEST['processIndexingQueue']) && $_REQUEST['processIndexingQueue']) {
			require_once(__CA_MODELS_DIR__.'/ca_search_indexing_queue.php');
			ca_search_indexing_queue::process();
			exit();
		}

		// run garbage collector
		GarbageCollection::gc();

		$app = AppController::getInstance();

		$g_request = $req = $app->getRequest();
		$g_response = $resp = $app->getResponse();

		// Prevent caching
		$resp->addHeader("Cache-Control", "no-cache, must-revalidate");
		$resp->addHeader("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");

		// Security headers
		$resp->addHeader("X-XSS-Protection", "1; mode=block");
		$resp->addHeader("X-Frame-Options", "SAMEORIGIN");
		$resp->addHeader("Content-Security-Policy", "script-src 'self' maps.googleapis.com cdn.knightlab.com nominatim.openstreetmap.org  ajax.googleapis.com tagmanager.google.com www.googletagmanager.com www.google-analytics.com www.google.com/recaptcha/ www.gstatic.com 'unsafe-inline' 'unsafe-eval';");
		$resp->addHeader("X-Content-Security-Policy", "script-src 'self' maps.googleapis.com cdn.knightlab.com nominatim.openstreetmap.org  ajax.googleapis.com  tagmanager.google.com www.googletagmanager.com www.google-analytics.com www.google.com/recaptcha/ www.gstatic.com 'unsafe-inline' 'unsafe-eval';");

		//
		// Don't try to authenticate when doing a login attempt or trying to access the 'forgot password' feature
		//
		if ((AuthenticationManager::supports(__CA_AUTH_ADAPTER_FEATURE_USE_ADAPTER_LOGIN_FORM__) && !preg_match("/^[\/]{0,1}system\/auth\/callback/", strtolower($req->getPathInfo()))) || !preg_match("/^[\/]{0,1}system\/auth\/(dologin|login|forgot|requestpassword|initreset|doreset|callback)/", strtolower($req->getPathInfo()))) {
			$vb_auth_success = $req->doAuthentication(array('noPublicUsers' => true));

			if(!$vb_auth_success) {
				$resp->sendResponse();
				$req->close();
				exit;
			}
		}

		// TODO: move this into a library so $_, $g_ui_locale_id and $g_ui_locale gets set up automatically
		$g_ui_locale_id = $req->user->getPreferredUILocaleID();			// get current UI locale as locale_id	 			(available as global)
		$g_ui_locale = $req->user->getPreferredUILocale();				// get current UI locale as locale string 			(available as global)
		$g_ui_units_pref = $req->user->getPreference('units');			// user's selected display units for measurements 	(available as global)

		if((!isset($_locale)) || ($g_ui_locale != $_COOKIE['CA_'.__CA_APP_NAME__.'_ui_locale'])) {
			if(!initializeLocale($g_ui_locale)) die("Error loading locale ".$g_ui_locale);
			$req->reloadAppConfig();
		}

		//
		// PageFormat plug-in generates header/footer shell around page content
		//
		require_once(__CA_APP_DIR__.'/lib/PageFormat.php');
		if (!$req->isAjax() && !$req->isDownload()) {
			$app->registerPlugin(new PageFormat());
		}

		//
		// Dispatch the request
		//
		$app->dispatch(true);

		//
		// Send output to client
		//
		$resp->sendResponse();
		$req->close();
	try {
	} catch (Exception $e) {
		caDisplayException($e);
	}


}

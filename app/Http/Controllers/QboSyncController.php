<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use QuickBooksOnline\API\DataService\DataService;

class QboSyncController extends Controller
{
    protected $OAuth2LoginHelper;

    public function initiateSync() {
        try {
            $dataService = DataService::Configure([
                'auth_mode' => config('qbosync.auth_mode'),
                'ClientID' => config('qbosync.client_id'),
                'ClientSecret' => config('qbosync.client_secret'),
                'RedirectURI' => config('qbosync.redirect_uri'),
                'scope' => config('qbosync.scope.accounting'),
                'baseUrl' => config('qbosync.base_url.development'),
            ]);

            $this->OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

            $authorizationHelper = $this->OAuth2LoginHelper->getAuthorizationCodeURL();

            return redirect($authorizationHelper);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function qboRedirect(Request $request) {
        Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));

        if (is_null($this->OAuth2LoginHelper)) {
            return response()->json([
                'error' => 'OAuth2LoginHelper is null',
                'request' => $request->all(),
            ], 500);
        }

        if (!$this->OAuth2LoginHelper instanceof OAuth2LoginHelper) {
            return $this->initiateSync();
        }

        if (empty($request->all())) return $this->initiateSync();

        // Get the access token and refresh token
        $this->accessTokenObj = $this->OAuth2LoginHelper->exchangeAuthorizationCodeForToken($request->get('code'), $request->get('realmId'));

        return $this->accessTokenObj;
    }
}

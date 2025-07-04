<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use QuickBooksOnline\API\DataService\DataService;

class QboSyncController extends Controller
{
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

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

            $authorizationHelper = $OAuth2LoginHelper->getAuthorizationCodeURL();

            return redirect($authorizationHelper);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

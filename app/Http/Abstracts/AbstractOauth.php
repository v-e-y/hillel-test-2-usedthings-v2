<?php

declare(strict_types=1);

namespace App\Http\Abstracts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

abstract class AbstractOauth extends Controller
{
    /**
     * Get lick to oauth resource
     * @param string $serviceName
     * @param array $parameters
     * @return string
     */
    protected static function getLoginDialogUri(string $serviceName, array $parameters): string
    {
        return config('oauth.' . $serviceName . '.oauth_url') . http_build_query($parameters);
    }

    /**
     * Check oauth request is he has error or code for request access token
     * @param Request $request
     * @return string|RedirectResponse
     */
    protected function getErrorOrCode(Request $request)
    {
        if ($request->error || !$request->code) {
            return redirect()->back()->withErrors([
                'msg' => 'Sorry we resewed some error(s)'
            ]);
        }

        return $request->code;
    }

    /**
     * @param string $serviceName
     * @param string $code
     * @return string
     */
    protected function getAccessToken(string $serviceName, string $code): string
    {
        $accessTokenRequest = Http::post(
            config('oauth.' . $serviceName . '.access_token_url'),
            [
                'client_id' => config('oauth.' . $serviceName . '.client_id'),
                'redirect_uri' => config('oauth.' . $serviceName . '.redirect_uri'),
                'client_secret' => config('oauth.' . $serviceName . '.client_secret'),
                'code' => $code
            ]
        );

        return $accessTokenRequest['access_token'];
    }
}

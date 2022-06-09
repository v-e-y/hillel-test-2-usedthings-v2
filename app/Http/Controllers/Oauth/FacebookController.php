<?php

declare(strict_types=1);

namespace App\Http\Controllers\Oauth;

use App\Http\Abstracts\AbstractOauth;
use App\Http\Contracts\OauthInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

final class FacebookController extends AbstractOauth implements OauthInterface
{
    private static string $serviceName = 'facebook';
    private string $serviceApiUrl;
    private string $fieldsToRequest;

    public function __construct()
    {
        $this->serviceApiUrl = config('oauth.' . self::$serviceName . '.api_url');
        $this->fieldsToRequest = config('oauth.' . self::$serviceName . '.fields_to_request');
    }

    /**
     * Get link for view to request oauth
     * @return string
     */
    public static function getRequestOauthLink(): string
    {
        return self::getLoginDialogUri(self::$serviceName, [
            'client_id' => config('oauth.' . self::$serviceName . '.client_id'),
            'redirect_uri' => config('oauth.' . self::$serviceName . '.redirect_uri'),
            'scope' => 'email'
        ]);
    }

    /**
     * Get and auth user from Facebook
     * @param Request $request
     * @return RedirectResponse
     */
    public function oauth(Request $request): RedirectResponse
    {
        $response = Http::get(
            $this->serviceApiUrl,
            [
                'fields' => $this->fieldsToRequest,
                'access_token' => $this->getAccessToken(
                    self::$serviceName,
                    $this->getErrorOrCode($request)
                ),
            ]
        );

        return $this->authUser(
            // The logic of our app means that we do not use e-mail.
            // We use a username but we cannot force the user to change their name
            // in Fb to make it unique.
            // Therefore, we will make a name for their Facebook users by e-mail.
            $response->json()['email'],
            // we will use Fb id as password
            $response->json()['id']
        );
    }

    /**
     * Auth user
     * @param string $name
     * @param string $id // user Fb id wich we will use for password
     * @return RedirectResponse
     * TODO: twice at the code maybe need to exclude to separate class/service etc  
     */
    private function authUser(string $name, string $id): RedirectResponse
    {
        if ($user = User::query()->where('username', $name)->first()) {
            if (Hash::check($id, $user->password)) {
                Auth::login($user, true);
                return redirect()->back();
            }

            return redirect()->back()->withErrors(['msg' => 'Wrong password']);
        }

        if (
            Auth::login(User::create([
                'username' => $name,
                'password' => Hash::make($id)
            ]), true)
        ) {
            return redirect()->back();
        }

        return redirect()->back()->withErrors(['msg' => 'Something wrong when auth']);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Contracts;

use Illuminate\Http\Request;

interface OauthInterface
{
    public function oauth(Request $request);

    public static function getRequestOauthLink(): string;
}

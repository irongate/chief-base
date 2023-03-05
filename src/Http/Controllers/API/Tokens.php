<?php

namespace ChiefTools\SDK\Http\Controllers\API;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class Tokens
{
    public function __invoke(Request $request): View
    {
        /** @var \ChiefTools\SDK\Entities\User $user */
        $user = $request->user();

        return view('chief::api.tokens.index', compact('user'));
    }

    public function create(Request $request): RedirectResponse
    {
        $queryParams = array_merge($request->query(), ['app' => config('chief.id')]);

        return redirect()->away(chief_base_url('api/token/create') . '?' . http_build_query($queryParams));
    }

    public function delete(Request $request, string $token): RedirectResponse
    {
        /** @var \ChiefTools\SDK\Entities\User $user */
        $user = $request->user();

        $user->personalAccessTokens()->findOrFail($token)->forceDelete();

        return redirect()->route('api.tokens')->with('message', [
            'text' => 'Personal access token deleted succesfully!',
            'type' => 'success',
        ]);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TokenModel;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $clientKey = $this->extractApiKey($request);

        // dd($clientKey);
        if (!$this->isValidApiKey($clientKey)) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access']);
        }

        return $next($request);
    }

    private function extractApiKey(Request $request)
    {
        $clientKey = $request->query('key');

        if (empty($clientKey)) {
            $clientKey = $request->header('X-Api-Key');
        }

        return $clientKey;
    }

    private function isValidApiKey($clientKey)
    {
        $validKeys = TokenModel::pluck('token')->toArray();

        return in_array($clientKey, $validKeys);
    }
}

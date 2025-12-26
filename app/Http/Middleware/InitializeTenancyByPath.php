<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Tenancy;
use Stancl\Tenancy\Resolvers\PathTenantResolver;

class InitializeTenancyByPath
{
    protected $tenancy;
    protected $resolver;

    public function __construct(Tenancy $tenancy)
    {
        $this->tenancy = $tenancy;
        $this->resolver = new PathTenantResolver;
    }

    public function handle(Request $request, Closure $next)
    {
        // Extrair tenant do path: /t/{tenant}/...
        $path = $request->path();

        if (preg_match('/^t\/([a-z0-9-]+)/', $path, $matches)) {
            $tenantSlug = $matches[1];

            try {
                $tenant = \App\Models\Central\Tenant::where('slug', $tenantSlug)->firstOrFail();
                $this->tenancy->initialize($tenant);
            } catch (\Exception $e) {
                abort(404, 'Tenant not found');
            }
        }

        return $next($request);
    }
}

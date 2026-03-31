<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckResponsibleProfile
{
    /**
     * Profile ID Constants
     */
    const PROFILE_ADMIN = 3;
    const PROFILE_AUDITOR = 4;

    public function handle(Request $request, Closure $next)
    {
        // 1. Leverage built-in auth guard for clarity
        if (Auth::guest()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $profileId = (int) $user->profile_id;

        // 2. Group Admin-only routes
        $adminRoutes = [
            'audit.values.index', 'audit.values.consult', 'audit.values.store',
            'audit.values.create', 'audit.values.show', 'audit.values.edit',
            'audit.values.update', 'audit.values.delete', 'audit.periods.*',
            'audit.relations.*', 'audit.columns.*', 'audit.tables.*'
        ];

        if ($request->routeIs($adminRoutes) && $profileId !== self::PROFILE_ADMIN) {
            return redirect('/error');
        }

        // 3. Group Auditor-only routes
        $auditorRoutes = ['audit.values.select', 'audit.values.view.*'];

        if ($request->routeIs($auditorRoutes) && $profileId !== self::PROFILE_AUDITOR) {
            return redirect('/error');
        }

        return $next($request);
    }
}

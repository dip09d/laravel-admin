<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getAdminMenus')) {

    function getAdminMenus()
    {
        $admin = Auth::guard('admin')->user();

        if (! $admin) {
            return collect();
        }

        if ($admin->hasRole('Super Admin')) {
            return Menu::where('parent_id', 0)
                ->with('children')
                ->orderBy('id')
                ->get();
        }

        $permissions = $admin->getAllPermissions()->pluck('name')->toArray();

        return Menu::where('parent_id', 0)
            ->with(['children' => function ($q) use ($permissions) {
                $q->whereHas('permission', function ($q2) use ($permissions) {
                    $q2->whereIn('name', $permissions);
                });
            }])
            ->whereHas('permission', function ($q) use ($permissions) {
                $q->whereIn('name', $permissions);
            })
            ->orderBy('id')
            ->get();
    }
}

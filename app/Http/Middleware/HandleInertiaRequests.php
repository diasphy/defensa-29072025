<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            // AQUÍ AÑADIMOS EL MENÚ
            'menu' => $request->user() ? $this->getMenuForUser($request->user()) : [],
        ];
    }

    /**
     * Obtener menús según el rol del usuario
     */
    private function getMenuForUser($user)
    {
        if (!$user || !$user->role_id) {
            return [];
        }

        // Obtener menús con sus submenús basados en el rol del usuario
        $menus = \App\Models\Menu::whereHas('subMenus.roles', function ($query) use ($user) {
                $query->where('role_id', $user->role_id)
                      ->where('role_submenu.is_active', true);
            })
            ->with(['subMenus' => function ($query) use ($user) {
                $query->whereHas('roles', function ($subQuery) use ($user) {
                    $subQuery->where('role_id', $user->role_id)
                             ->where('role_submenu.is_active', true);
                })
                ->where('is_active', true)
                ->orderBy('order');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return $menus->map(function ($menu) {
            return [
                'id' => $menu->id,
                'name' => $menu->name,
                'route' => $menu->route,
                'icon' => $menu->icon,
                'subMenus' => $menu->subMenus->map(function ($subMenu) {
                    return [
                        'id' => $subMenu->id,
                        'name' => $subMenu->name,
                        'route' => $subMenu->route,
                        'icon' => $subMenu->icon,
                        'description' => $subMenu->description,
                    ];
                }),
            ];
        });
    }
}
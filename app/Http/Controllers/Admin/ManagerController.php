<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\RedisHelper;
use App\Http\Requests\Admin\ManagerCreateRequest;
use App\Models\Manager;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ManagerController extends BaseAdminController
{
    public function list(Request $request): Factory|View|Application
    {
        return view('admin.managers.list', [
            'managers' => Manager::query()->paginate($request->get('limit'))
        ]);
    }


    /**
     * Страница регистрации нового менеджера
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        return view('admin.managers.add');
    }

    /**
     * Сохранение менеджера
     *
     * @param ManagerCreateRequest $request
     * @return RedirectResponse
     */
    public function store(ManagerCreateRequest $request): RedirectResponse
    {
        $manager             = new Manager();
        $manager->name       = $request->get('name');
        $manager->surname    = $request->get('surname');
        $manager->patronymic = $request->get('patronymic');
        $manager->email      = $request->get('email');
        $manager->password   = Hash::make($request->get('password'));

        if ($manager->save()) {
            Session::flash('success', 'Пользователь создан, укажите права доступа');

            return redirect()->route('admin.managers.edit', $manager->id);
        }

        Session::flash('error', 'Сохранить менеджера не удалось, пожалуйста попробуйте позже');

        return redirect()->back()->withInput();
    }

    /**
     * Форма назначения ролей менеджеру
     *
     * @param Manager $manager
     * @return Application|Factory|\Illuminate\View\View
     */
    public function edit(Manager $manager)
    {
        $roles = Role::query()->orderBy('description')->get();

        return view('admin.managers.edit', compact('manager', 'roles'));
    }

    /**
     * Обновление ролей менеджера
     *
     * @param Manager $manager
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Manager $manager, Request $request): RedirectResponse
    {
        Session::flash('error', 'Контент в разработке');

        return redirect()->back();
        $rolesForSet            = array_keys($request->get('role', []));
        $adminRoleId            = Role::query()->where('name', Manager::ADMIN)->get('id')->pluck('id')->first();
        $isEditableManagerAdmin = $manager->hasRole(Manager::ADMIN);

        // Если кто то без роли админа пытается её добавить
        if (in_array($adminRoleId, $rolesForSet) && Gate::denies('adminRoleAccess', Manager::class)) {
            Session::flash('error', 'У вас недостаточно прав для работы с ролью Администратора');

            return redirect()->back();
        }

        // Если кто то без роли админа пытается изменить роли другого Админа
        if ($isEditableManagerAdmin && Gate::denies('adminRoleAccess', Manager::class)) {
            Session::flash('error', 'У вас недостаточно прав для работы с правами Администратора');

            return redirect()->back();
        }

        if (!empty($rolesForSet)) {
            $result = $manager->roles()->sync($rolesForSet);
        } else {
            $result = $manager->roles()->detach();
        }

        if (!$result) {
            Log::error('При попытке изменить роли пользователя возникла ошибка', [
                'role_id'    => $request->get('role_id'),
                'manager_id' => $manager->id,
            ]);

            Session::flash('error', 'Не удалось изменить роли пользователя. Пожалуйста попробуйте позже');

            return redirect()->back();
        }

        Session::flash('success', 'Роли изменены, пользователю необходимо перезайти в кабинет');

        return redirect()->route('admin.managers.index');
    }

    /**
     * Метод получения супертокена
     *
     * @param RedisHelper $redisHelper
     * @return RedirectResponse
     */
    public function superToken(RedisHelper $redisHelper): RedirectResponse
    {
        $token = $redisHelper->setTokenKey(Hash::make('super_powers'), 120);

        if (!$token) {
            Session::flash('error', 'Не удалось получить супертокен. Попробуйте позже.');
        } else {
            Session::flash('success', 'Токен: ' . $token);
        }

        return redirect()->back();
    }
}

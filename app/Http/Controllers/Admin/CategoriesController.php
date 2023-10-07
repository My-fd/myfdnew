<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryColor;
use App\Models\Listing;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Контроллер для управления категориями
 *
 * Class CategoriesController
 * @package App\Http\Controllers\Admin
 */
class CategoriesController extends Controller
{
    /**
     * Список всех категорий
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function list(Request $request)
    {
        return view('admin.categories.list', [
            'categories' => Category::query()->paginate($request->get('limit', 50)),
        ]);
    }

    /**
     * Страница редактирования категориюа
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Метод редактирования категории
     *
     * @param Category        $category
     * @param CategoryRequest $updateRequest
     * @return RedirectResponse
     */
    public function update(Category $category, CategoryRequest $updateRequest): RedirectResponse
    {
        // if ($category->isRootCategory()) {
        //     Session::flash('error', 'Редактирование корневой категории запрещено');
        //
        //     return redirect()->back();
        // }

        $category->name = $updateRequest->get('name');

        // Загрузка изображения
        if ($updateRequest->hasFile('image')) {
            Storage::delete($category->image_url); // Удалить старое изображение
            $imagePath           = $updateRequest->file('image')->store(Category::FILE_DIR, 'public');
            $category->image_url = $imagePath;
        }

        if (!$category->update()) {
            Session::flash('error', 'Не удалось обновить категорию. Пожалуйста, попробуйте позже');

            Log::error('Не удалось обновить категорию.', [
                'request' => $updateRequest->all(),
            ]);

            return redirect()->back();
        }

        return redirect()->route('admin.categories.list');
    }

    /**
     * Страница добавления
     *
     * @return Application|Factory|View
     */
    public function add()
    {
        return view('admin.categories.add');
    }

    /**
     * Метод создания новой категории
     *
     * @param Category        $category
     * @param CategoryRequest $createRequest
     * @return RedirectResponse
     */
    public function store(CategoryRequest $createRequest): RedirectResponse
    {
        $category       = new Category();
        $category->name = $createRequest->get('name');

        // Загрузка изображения
        if ($createRequest->hasFile('image')) {
            $imagePath           = $createRequest->file('image')->store(Category::FILE_DIR, 'public');
            $category->image_url = $imagePath;
        }

        if (!$category->save()) {
            Session::flash('error', 'Не удалось создать категорию. Пожалуйста, попробуйте позже');

            Log::error('Не удалось создать категорию.', [
                'request' => $createRequest->all(),
            ]);

            return redirect()->back();
        }

        return redirect()->route('admin.categories.list');
    }

    /**
     * Метод удаления категории
     *
     * @param Category $category
     * @param Request  $request
     * @return RedirectResponse
     */
    public function delete(Category $category, Request $request): RedirectResponse
    {
        Session::flash('error', 'Удаление пока не работает.');

        return redirect()->back();

        if ($category->isRootCategory()) {
            Session::flash('error', 'Невозможно удалить корневую категорию.');

            return redirect()->back();
        }

        /** @var Category $rootCategory */
        $rootCategory = Category::query()->where('name', Category::ROOT_CATEGORY)->first();

        DB::beginTransaction();

        Listing::query()->where('category_id', '=', $category->id)->update(['category_id' => $rootCategory->id]);

        if (!$category->delete()) {
            Session::flash('error', 'Не удалось удалить категорию. Пожалуйста попробуйте позже');

            Log::error('Не удалось удалить категорию.', [
                'request' => $request->all(),
            ]);

            DB::rollBack();

            return redirect()->back();
        }

        DB::commit();

        return redirect()->route('admin.categories.list');
    }
}

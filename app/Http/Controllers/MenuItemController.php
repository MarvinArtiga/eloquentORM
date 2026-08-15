<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::query();

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        return MenuItemResource::collection($query->get());
    }

    public function store(StoreMenuItemRequest $request): JsonResponse
    {
        $item = MenuItem::create($request->validated());

        return (new MenuItemResource($item))->response()->setStatusCode(201);
    }

    public function show(MenuItem $menuItem)
    {
        return new MenuItemResource($menuItem);
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());

        return new MenuItemResource($menuItem);
    }

    public function destroy(MenuItem $menuItem): JsonResponse
    {
        $menuItem->delete();

        return response()->json(null, 204);
    }

    public function byCategory(string $category)
    {
        $items = MenuItem::where('category', $category)->get();

        return MenuItemResource::collection($items);
    }
}

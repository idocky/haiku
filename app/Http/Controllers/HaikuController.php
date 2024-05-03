<?php

namespace App\Http\Controllers;

use App\Http\Requests\HaikuRequest;
use App\Http\Resources\CreateHaikuResource;
use App\Http\Resources\EditHaikuResource;
use App\Http\Resources\IndexHaikuResource;
use App\Models\Haiku;
use App\Models\Theme;
use Illuminate\Http\Request;

class HaikuController extends Controller
{
    public function index()
    {
        $haiku = Haiku::all();

        return IndexHaikuResource::collection($haiku);
    }

    public function create()
    {
        $themes = Theme::all();

        return new CreateHaikuResource([
            'themes' => $themes
        ]);
    }

    public function store(HaikuRequest $request)
    {
        $haiku = Haiku::add($request->all());
        $haiku->setUser($request->get('user_id'));
        $haiku->setTheme($request->get('theme_id'));
        $haiku->toggleStatus($request->get('is_hidden'));

        return response()->json(['message' => 'created'], 201);
    }

    public function edit($slug)
    {
        $themes = Theme::all();
        $haiku = Haiku::findBySlug($slug);

        return new EditHaikuResource([
                'themes' => $themes,
                'haiku' => $haiku
            ]
        );
    }

    public function update(HaikuRequest $request, $slug)
    {
        $haiku = Haiku::findBySlug($slug);
        $haiku->edit($request->all());
        $haiku->setUser($request->get('user_id'));
        $haiku->setTheme($request->get('theme_id'));
        $haiku->toggleStatus($request->get('is_hidden'));

        return response()->json(['message' => 'updated'], 200);
    }

    public function destroy($slug)
    {
        Haiku::findBySlug($slug)->delete();
        return response()->json([], 204);
    }

    public function show($slug)
    {
        $haiku = Haiku::findBySlug($slug);

        return new IndexHaikuResource($haiku);
    }
}

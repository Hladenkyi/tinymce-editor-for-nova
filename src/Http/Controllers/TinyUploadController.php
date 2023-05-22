<?php

namespace Hladenkyi\Editor\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;

class TinyUploadController extends Controller
{
    public function store(NovaRequest $request)
    {
        $field = $request->newResource()
            ->availableFields($request)
            ->findFieldByAttribute($request->field, function () {
                abort(404);
            });

        $path = $request->file('file')->storePublicly($field->storagePath, $field->disk);
        $url = \Storage::url($path);

        return response()->json(['location' => asset($url)]);
    }

    public function destroy(NovaRequest $request)
    {

        $field = $request->newResource()
            ->availableFields($request)
            ->findFieldByAttribute($request->field, function () {
                abort(404);
            });

        $path = \Str::afterLast($request->url, 'storage/');
        \Storage::disk($field->disk)->delete($path);
        return response()->noContent();
    }
}

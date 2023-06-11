<?php

namespace Hladenkyi\Editor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $url = Storage::disk($field->disk)->url($path);

        return response()->json(['location' => asset($url)]);
    }

    public function destroy(NovaRequest $request)
    {

        $field = $request->newResource()
            ->availableFields($request)
            ->findFieldByAttribute($request->field, function () {
                abort(404);
            });

        $path = Str::afterLast($request->url, $field->disk === 'public' ? 'storage/' : 'storage/' . $field->disk . '/');

        Storage::disk($field->disk)->delete($path);
        return response()->noContent();
    }
}

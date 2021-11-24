<?php

namespace App\Http\Controllers;

use App\Models\FileImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FileImportsController extends Controller
{
    public function import(Request $request): RedirectResponse
    {
        $file = new FileImport();
        $file->user_id = $request->user()->id;
        $file->path = $request->file('file')->store('tmp');
        $file->save();
        return response()->redirectTo(route(
            'file.from-to',
            ['hash' => $file->hash->toString()]
        ));
    }

    public function fromTo(Request $request, string $hash)
    {
        return response(null);
    }
}

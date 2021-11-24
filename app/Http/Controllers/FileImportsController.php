<?php

namespace App\Http\Controllers;

use App\Models\FileImport;
use App\Services\FileImportsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FileImportsController extends Controller
{
    /**
     * Store the uploaded file and save a register on `file_imports`
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $file = FileImportsService::create(
            $request->file('file'),
            $request->user()
        );

        return response()->redirectTo(route(
            'file.from-to',
            ['hash' => $file->hash->toString()]
        ));
    }

    public function fromTo(Request $request, string $hash)
    {
        $file = FileImport::byHashUser($hash, $request->user())->firstOrFail();
        return response(null);
    }
}

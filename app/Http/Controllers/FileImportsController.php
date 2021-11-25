<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\FileImport;
use App\Models\User;
use App\Services\FileImportsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileImportsController extends Controller
{
    /**
     * @var FileImportsService
     */
    protected FileImportsService $service;

    public function importForm(Request $request)
    {
        return view('file-import-form');
    }

    /**
     * Store the uploaded file and save a register on `file_imports`
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $file = $this->getService(
            $request->user()
        )->create($request->file('file'));
        return response()->redirectTo(route(
            'file.from-to',
            ['hash' => $file->hash->toString()]
        ));
    }

    public function fromTo(Request $request, string $hash)
    {
        $fromTo = $this->getService(
            $request->user()
        )->getFromToColumns($hash, Contact::class);
        return view('from-to-form', $fromTo);
    }

    protected function getService(User $user): FileImportsService
    {
        if (empty($this->service)) {
            $this->service = new FileImportsService($user);
        }
        return $this->service;
    }
}

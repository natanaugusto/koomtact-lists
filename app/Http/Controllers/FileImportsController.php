<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessFileImports;
use App\Models\Contact;
use App\Models\User;
use App\Services\FileImportsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class FileImportsController extends Controller
{
    /**
     * @var FileImportsService
     */
    protected FileImportsService $service;

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

    /**
     * @param Request $request
     * @param string $hash
     * @return View
     */
    public function fromTo(Request $request, string $hash): View
    {
        $fromTo = $this->getService(
            $request->user()
        )->getFromToColumns(Contact::class, $hash);
        return view('from-to-form', array_merge($fromTo, ['hash' => $hash]));
    }

    /**
     * @param Request $request
     * @param string $hash
     * @return RedirectResponse
     */
    public function storeFromTo(Request $request, string $hash): RedirectResponse
    {
        $fileImport = $this->getService($request->user())->getHandlerByHash($hash, true);
        $fileImport->from_to = Arr::except($request->all(), ['_method', '_token']);
        $fileImport->save();
        ProcessFileImports::dispatch($fileImport);
        return response()->redirectTo(route('contacts'));
    }

    public function files(Request $request): View
    {
        return view('files', ['files' => $request->user()->files]);
    }

    /**
     * @param User $user
     * @return FileImportsService
     */
    protected function getService(User $user): FileImportsService
    {
        if (empty($this->service)) {
            $this->service = new FileImportsService($user);
        }
        return $this->service;
    }
}

<?php

namespace App\Http\Controllers;

use App\DownloadRequests;
use App\Jobs\DownloadPOCData;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * @return string
     */
    public function export() {

        $downloadRequest = DownloadRequests::create();

        DownloadPOCData::dispatch($downloadRequest);

        return "Your request is in progress. You can visit <a href='/export/status/$downloadRequest->id'> the link</a> to check the progress!";
    }

    /**
     * @param DownloadRequests $downloadRequests
     * @return RedirectResponse
     */
    public function download(DownloadRequests $downloadRequests) {

        if($downloadRequests->percentage !== 100) {
            redirect()->route('exportStatus', [$downloadRequests->id]);
        }
        return Storage::disk('exports')->download($downloadRequests->id.'.zip');

    }

    /**
     * @param DownloadRequests $downloadRequests
     * @return string
     */
    public function status(DownloadRequests $downloadRequests) {

        return view('status', [ 'downloadRequests' => $downloadRequests]);

    }

    /**
     * @param DownloadRequests $downloadRequests
     * @return ResponseFactory|Response
     */
    public function percentage(DownloadRequests $downloadRequests) {

        return response(['percentage' => $downloadRequests->percentage], 200);

    }
}

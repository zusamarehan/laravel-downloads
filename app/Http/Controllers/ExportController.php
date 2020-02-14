<?php

namespace App\Http\Controllers;

use App\DownloadRequests;
use App\Jobs\CreateExcel;
use App\Jobs\DownloadPOCData;
use App\Jobs\ZipExcels;
use App\Projects;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * @return string
     */
    public function export() {
        $downloadRequest = DownloadRequests::create();

        $jobListing = [];

        $allPOC = Projects::with(['cases', 'notes', 'tasks'])->get();

        // Creating New Job per Project and then pushing it to Job List Array
        foreach ($allPOC as $poc){
            array_push($jobListing, new CreateExcel($allPOC, $poc->id, $downloadRequest));
        }
        // Create New Job for Zipping Files and push to Job List Array
        array_push($jobListing, new ZipExcels($downloadRequest));
        // Dispatch All Jobs
        DownloadPOCData::withChain($jobListing)->dispatch();

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

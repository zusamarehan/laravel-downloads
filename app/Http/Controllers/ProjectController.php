<?php

namespace App\Http\Controllers;

use App\DownloadRequests;
use App\Http\Resources\ProjectResource;
use App\Jobs\CreateExcel;
use App\Jobs\DownloadPOCData;
use App\Jobs\ZipExcels;
use App\JobWatchers;
use App\Projects;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Function to display all the Project Resources available
     * @return AnonymousResourceCollection
     */
    public function index() {

        return ProjectResource::collection(Projects::with(['cases', 'notes', 'tasks'])->get());

    }

    /**
     * Function to display the requested Project Resources
     * @param Projects $project
     * @return ProjectResource
     */
    public function show(Projects $project) {

        return new ProjectResource($project->load(['cases', 'notes', 'tasks']));

    }

    /**
     * @return string
     */
    public function export()
    {

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

        return 'Your request is in progress. You can visit the link to check the progress!';

    }

}

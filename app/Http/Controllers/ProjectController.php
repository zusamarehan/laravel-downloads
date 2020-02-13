<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Jobs\DownloadPOCData;
use App\Projects;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        // usually we get this from auth()
        $organizationID = 10;

        // Get all the projects for the Specified Project ID
        $allPOC = Projects::with(['organization', 'cases', 'notes', 'tasks'])
                            ->where('organizations_id', $organizationID)
                            ->get();

        DownloadPOCData::dispatch($allPOC);

        return 'Your request is in progress. You can visit the link to check the progress!';

    }


    public function exportProgress($id) {



    }
}

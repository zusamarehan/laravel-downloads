<?php

namespace App\Http\Controllers;

use App\Exports\DownloadPOC;
use App\Http\Resources\ProjectResource;
use App\Projects;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @return BinaryFileResponse
     */
    public function export()
    {

        return Excel::download(new DownloadPOC(Projects::with(['cases', 'notes', 'tasks'])->get()), 'POC Data.xlsx');
    }
}

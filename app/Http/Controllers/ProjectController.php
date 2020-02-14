<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
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


}

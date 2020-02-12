<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function index() {

        return ProjectResource::collection(Projects::with(['cases', 'notes', 'tasks'])->get());

    }

    //
    public function show(Projects $project) {

        return new ProjectResource($project->load(['cases', 'notes', 'tasks']));

    }
}

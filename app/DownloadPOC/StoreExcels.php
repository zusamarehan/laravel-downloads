<?php
/**
 * Created by PhpStorm.
 * User: zrehan
 * Date: 29/1/20
 * Time: 10:01 PM
 */

namespace App\DownloadPOC;

use App\Exports\DownloadPOC;
Use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class StoreExcels
{
    /**
     * @param Collection $project
     * @param Closure $next
     * @return mixed
     */
    public function handle(Collection $project, Closure $next) {

        $organization = $project->first()->load('organization')->organization->name;
        Storage::disk('exports')->makeDirectory($organization);

        foreach ($project as $poc){
            Excel::store(new DownloadPOC($project, $poc->id), $organization.'/'.$poc->title.' POC Data.xlsx', 'exports');
        }

        return $next($project);

    }
}

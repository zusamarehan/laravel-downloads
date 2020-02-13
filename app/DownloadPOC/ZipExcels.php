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

class ZipExcels
{
    /**
     * @param Collection $project
     * @param Closure $next
     * @return mixed
     */
    public function handle(Collection $project, Closure $next) {

        $organization = $project->first()->load('organization')->organization->name;

        // Name of the archive to download
        $zipFile = $organization.'.zip';

        // Initializing PHP class
        $zip = new \ZipArchive();
        $zip->open(storage_path('app/public/poc/'.$zipFile), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        // get all the POC Data Excels files for the Organization
        $projectExcels = Storage::disk('exports')->files('Carole Ferry');

        foreach ($projectExcels as $projectExcel){
            // Adding file: second parameter is what will the path inside of the archive
            // So it will create another folder called "storage/" inside ZIP, and put the file there.
            $zip->addFile(storage_path('app/public/poc/').$projectExcel, $projectExcel);

        }

        $zip->close();

        return $next($project);

    }
}

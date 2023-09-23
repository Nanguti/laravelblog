<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Goutte\Client;

class JobListingController extends Controller
{
    public function importJobs()
    {
        $xmlData = Http::get('https://www.myjobmag.co.ke/jobsxml.xml')->body();

        // Parse XML using SimpleXMLElement
        $xml = new \SimpleXMLElement($xmlData);

        // Create a Goutte client
        $client = new Client();

        foreach ($xml->channel->item as $item) {
            $title = (string)$item->title;
            $industry = (string)$item->industry;
            $link = (string)$item->link;
            $description = (string)$item->description;
            $publishDate = (string)$item->pubDate;

            // Check if the job already exists in the database
            $existingJob = DB::table('job_listings')->where('link', $link)->first();

            if (!$existingJob) {
                // Job does not exist, insert it
                $additionalDetails = $this->fetchAdditionalDetails($client, $link);

                $jobListingId = DB::table('job_listings')->insertGetId([
                    'title' => $title,
                    'date_published' => $publishDate,
                    'description' => $description,
                    'industry' => $industry,
                    'job_key_info' => $additionalDetails['job_key_info'],
                    'job_details' => $additionalDetails['job_details'],
                    'application_method' => $additionalDetails['application_method'],
                    'link' => $link, // Include the link as a unique identifier
                ]);
            }
        }

        return "Job listings imported successfully!";
    }


    private function fetchAdditionalDetails($client, $link)
    {
        $crawler = $client->request('GET', $link);

        $jobDetails = $crawler->filter('#printable .job-details')->html();
        $job_key_info = $crawler->filter('#printable .job-key-info')->html();
        $applicationMethod = $crawler->filter('#printable .bm-b-30')->html();
        

        // Return the extracted information
        return [
            'job_details' => $jobDetails,
            'job_key_info' => $job_key_info,
            'application_method' => $applicationMethod,
        ];
    }

    public function jobList(){
        $jobs = DB::table('job_listings')
            ->orderByRaw("STR_TO_DATE(date_published, '%a, %d %b %Y %H:%i:%s GMT') DESC")
            ->paginate(10);
        return response()->json(['jobs' => $jobs]);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Goutte\Client;
use Illuminate\Http\Request;

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
            $slug  = $this->createSlugFromTitle($title);

            // Check if the job already exists in the database
            $existingJob = DB::table('job_listings')->where('slug', $slug)->first();

            if (!$existingJob) {
                // Job does not exist, insert it
                $additionalDetails = $this->fetchAdditionalDetails($client, $link);

                $jobListingId = DB::table('job_listings')->insertGetId([
                    'title' => $title,
                    'slug' => $slug,
                    'date_published' => $publishDate,
                    'description' => $description,
                    'industry' => $industry,
                    'job_key_info' => $additionalDetails['job_key_info'],
                    'job_details' => $additionalDetails['job_details'],
                    'application_method' => $additionalDetails['application_method'],
                    'link' => $link,
                ]);
            }
        }

        return "Job listings imported successfully!";
    }


    function createSlugFromTitle($title) 
    {
        $slug = strtolower(str_replace(' ', '-', $title));
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
    
        return $slug;
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
            ->paginate(20);
        return response()->json(['jobs' => $jobs]);

    }

    public function jobDetail(Request $request){
        $jodDetails = JobListing::where('slug',$request->slug)->first();
        return response()->json(['jobDetails' => $jodDetails]);
    }

    public function autocompleteSearch(Request $request){
        $query = $request->query('query');

        $suggestions = JobListing::whereRaw("MATCH(title, slug, description, industry, job_key_info, job_details) AGAINST(? IN BOOLEAN MODE)", [$query])
            ->orderByRaw("STR_TO_DATE(date_published, '%a, %d %b %Y %H:%i:%s GMT') DESC")
            ->limit(10)
            ->get();

            $suggestionData = $suggestions->map(function ($job) {
            return [
                'id' => $job->id,
                'label' => $job->title,
                'slug' => $job->slug,
                'description' => $job->description
            ];
        });
    
        return response()->json([
            'suggestions' => $suggestionData,
        ]);
    }    
    
    
}

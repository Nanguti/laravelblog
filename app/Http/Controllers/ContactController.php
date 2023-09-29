<?php

namespace App\Http\Controllers;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submitForm(Request $request)
    {
        Log::info($request->all());
        // Send the email
        Mail::to('g.nanguti@gmail.com')->send(new ContactFormMail(
            
            $request->input('first-name') . ' ' . $request->input('last-name'),
            $request->input('email'),
            $request->input('message')
        ));

        // Redirect or respond as needed
    }
}

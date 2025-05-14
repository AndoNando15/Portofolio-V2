<?php

namespace App\Http\Controllers;

use App\Models\Error;
use Illuminate\Http\Request;

class ErrorPageController extends Controller
{
    public function index()
    {
        // Fetch all entries from the '404' table (Error model)
        $errors = Error::all();

        // Dump and die to inspect the content of $errors
        dd($errors);  // This will output the content of $errors and stop the execution

        return view('404', compact('errors'));
    }


}
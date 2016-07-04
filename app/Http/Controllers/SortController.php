<?php

namespace App\Http\Controllers;

use App\Http\ServiceLayer\SortService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SortController extends Controller
{
    public function sort(Request $request, SortService $service)
    {
        $inputType = $request->header('content-type');
        $outputType = $request->header('accept');
        $books = $request->getContent();
        $strategy = $request->get('strategy') ?: [];

        $response = $service->execute($inputType, $outputType, $books, $strategy);

        return (new Response($response, 200))
                  ->header('Content-Type', $outputType);
    }
}

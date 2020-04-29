<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserPostsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (env('APP_ENV')=='local') sleep(1); //add delay when querying on local development
        return response()->json([
            'data'=>$request->user()->posts()
        ]);
    }
}

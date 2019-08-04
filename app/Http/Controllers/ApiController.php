<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\News as NewsResource;
use App\News;

class ApiController extends Controller
{
    public function getNews()
    {
        //$news = News::all();
        return NewsResource::collection(News::all());
    }
}

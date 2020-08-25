<?php

namespace App\Http\Controllers;
set_time_limit(0);
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;
use Log;
class HomeController extends Controller
{
    public function send()
    {
         Log::info("Request Cycle with Queues Begins");
       $this->dispatch(new SendWelcomeEmail());
       echo'sdf';
      // print_r($dd);
        Log::info("Request Cycle with Queues Ends");
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralUser;
use App\Models\Office;
use App\Models\Post;
use App\Models\PostsRequest;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function get() {

        $sale_posts = [
            'active_posts' => Post::whereStatus('active')->where('columns->listing_type', 'For Sale')->count(),
            'inactive_posts' => Post::whereStatus('inactive')->where('columns->listing_type', 'For Sale')->count(),
        ];

        $rent_posts = [
            'active_posts' => Post::whereStatus('active')->where('columns->listing_type', 'For Rent')->count(),
            'inactive_posts' => Post::whereStatus('inactive')->where('columns->listing_type', 'For Rent')->count(),
        ];

        $date = request('date');
        $city = request('city');

        return $this->generalResponse([
            'sale_posts' => $sale_posts,
            'rent_posts' => $rent_posts,
            'posts_requests' => PostsRequest::count(),
            'offices' => is_null($date) ? Office::count() : Office::whereDate('created_at', $date)->count(),
            'general_users' => (function($date, $city) {
                $general_users = GeneralUser::query();
                if($date)
                    $general_users->whereDate('created_at', $date);
                if($city)
                    $general_users->whereCity($city);
                return $general_users->count();
            })($date, $city)
        ]);

    }
}

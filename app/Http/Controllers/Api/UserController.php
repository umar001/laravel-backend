<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsFeedRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Responses\ApiResponse;
use App\Models\PersonalizeFeed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    protected $user;

    /**
     * __construct
     *
     * @param  mixed $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserDetails()
    {
        try {
            $user = User::with("newsFeed")->find(Auth::id())->toArray();
            return ApiResponse::success($this->userWithNewsFeedArr($user));
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return ApiResponse::error($th);
        }
    }

    public function storeNewsFeed(NewsFeedRequest $request)
    {
        try {
            $validate = $request->validated();
            $user_id = Auth::id();
            $response =  PersonalizeFeed::updateOrCreate([
                "user_id" => $user_id
            ], $validate);
            return ApiResponse::success([
                "news_source" => $response->news_source,
                "category" => $response->category,
                "author" => $response->author
            ]);
        } catch (\Throwable $th) {
            return ApiResponse::error($th);
        }
    }

    public function updateProfile(ProfileRequest $request)
    {
        try {
            $validate = $request->validated();
            $response = User::updateOrCreate([
                'id' => Auth::id()
            ], $validate);
            return ApiResponse::success(["name" => $response->name]);
        } catch (\Throwable $th) {
            return ApiResponse::error($th);
        }
    }

    private function userWithNewsFeedArr($data)
    {
        $arr = [
            'name' => $data["name"],
            'email' => $data["email"],
            "news_feed" => [
                "news_source" => isset($data["news_feed"]['news_source']) ? $data["news_feed"]['news_source'] : "",
                "category" => isset($data["news_feed"]['category']) ? $data["news_feed"]['category'] : "",
                "author" => isset($data["news_feed"]['author']) ? $data["news_feed"]['author'] : "",
            ]
        ];
        return $arr;
    }
}

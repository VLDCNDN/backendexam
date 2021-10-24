<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $page = isset($request->page) ? (int) $request->page : 1;
        $hashKey = "users:page_{$page}";
        $users = $this->getRedis($hashKey);

        if (!$users) {
            $users = User::orderBy('name')->paginate(10);
            $this->setRedis($hashKey, $users);
        }

        return $users;
    }

    public function filter($username)
    {
        $users = array_map('trim', explode(",", $username));
        $data = [];
        foreach ($users as $i) {
            $user = $this->getRedis($i);
            if (!$user) {

                $user = User::where('username', $i)->first();
                if (!empty($user)) {
                    $data[] = $user;
                    $this->setRedis("user:{$user->username}", $users);
                }
            } else {
                $data[] = $user;
            }
        }

        // Sort multidimensional array by github name
        usort($data, function ($a, $b) {
            return $a->name <=> $b->name;
        });

        return response($data, Response::HTTP_OK);
    }
}

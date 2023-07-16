<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('panel.teacher.view',
            [
                'customersData' => [
                    (object) [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'email' => 'johndoe@example.com',
                        'country_code' => '+1',
                        'mobile' => '1234567890',
                        'is_active' => true,
                        'is_verified' => true,
                        'created_at' => '2023-05-15 10:30:00',
                        'id' => 1
                    ],
                    (object) [
                        'first_name' => 'Jane',
                        'last_name' => 'Smith',
                        'email' => 'janesmith@example.com',
                        'country_code' => '+44',
                        'mobile' => '9876543210',
                        'is_active' => false,
                        'is_verified' => true,
                        'created_at' => '2023-05-14 15:45:00',
                        'id' => 2
                ]
            ]]
        );
    }
}

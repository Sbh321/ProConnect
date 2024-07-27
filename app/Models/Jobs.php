<?php

namespace App\Models;

class Jobs
{
    public static function all()
    {
        return [
            [
                'id' => 1,
                'title' => 'PHP Developer',
                'description' => 'We are looking for a PHP developer to join our team.',
            ],
            [
                'id' => 2,
                'title' => 'Python Developer',
                'description' => 'We are looking for a Python developer to join our team.',
            ],
            [
                'id' => 3,
                'title' => 'Frontend Developer',
                'description' => 'We are looking for a frontend developer to join our team.',
            ],
            [
                'id' => 4,
                'title' => 'Backend Developer',
                'description' => 'We are looking for a backend developer to join our team.',
            ],
        ];
    }

    public static function find($id)
    {
        $jobs = self::all();

        foreach ($jobs as $job) {
            if ($job['id'] == $id) {
                return $job;
            }
        }
    }
}

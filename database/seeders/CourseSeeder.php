<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['course_name' => 'Aljabar Linear', 'credits' => 2],
            ['course_name' => 'Matematika Diskrit 2', 'credits' => 3],
            ['course_name' => 'Pengantar Rekayasa Perangkat Lunak', 'credits' => 4],
            ['course_name' => 'Pemrograman Berorientasi Objek', 'credits' => 3],
            ['course_name' => 'Basis Data', 'credits' => 4],
            ['course_name' => 'Komputer Grafik', 'credits' => 3],
            ['course_name' => 'Proyek 3 : Pengembangan Perangkat Lunak Berbasis Web', 'credits' => 3],

            ['course_name' => 'Etika Profesi', 'credits' => 2],
            ['course_name' => 'Pengantar Pengembangan Perangkat Lunak Industri', 'credits' => 3],
            ['course_name' => 'Komunikasi Teknis dan Bisnis Pengembangan Perangkat Lunak Industri', 'credits' => 6],
            ['course_name' => 'Best Practices Pengembangan Perangkat Lunak Industri', 'credits' => 4],
            ['course_name' => 'Kerja Praktik', 'credits' => 6],
            ['course_name' => 'Proyek 5 : Studi Kelayakan Pengembangan Perangkat Lunak Aplikasi', 'credits' => 2],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Quiz, Question, Option};

class StarterSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active'=> true,
            ]
        );

        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active'=> true,
                'access_starts_at' => now()->subDay(),
                'access_ends_at'   => now()->addMonths(2),
            ]
        );

        // Sample Reading Quiz
        $r = Quiz::create([
            'title' => 'Reading Demo (Opinion Matching)',
            'skill' => 'reading',
            'description' => 'Demo 4 statements ↔ 4 opinions',
            'is_published' => true,
            'duration_minutes' => 20,
        ]);

        $q1 = Question::create([
            'quiz_id'=>$r->id,'stem'=>'Statement A: ...','type'=>'single','order'=>1
        ]);
        foreach (['Opinion 1','Opinion 2','Opinion 3','Opinion 4'] as $i => $lbl) {
            Option::create([
                'question_id'=>$q1->id,'label'=>$lbl,'is_correct'=> ($i==1), 'order'=>$i+1
            ]);
        }

        // Sample Listening Quiz (no audio files yet)
        $l = Quiz::create([
            'title' => 'Listening Demo (1 recording)',
            'skill' => 'listening',
            'description' => 'Demo single question without audio file',
            'is_published' => true,
            'duration_minutes' => 15,
            'allow_seek' => false,
            'listens_allowed' => 1,
        ]);

        $q2 = Question::create([
            'quiz_id'=>$l->id,'stem'=>'What is the main idea?','type'=>'single','order'=>1,'audio_path'=>null
        ]);
        foreach (['A','B','C','D'] as $i => $lbl) {
            Option::create([
                'question_id'=>$q2->id,'label'=>$lbl,'is_correct'=> ($i==0), 'order'=>$i+1
            ]);
        }
    }
}

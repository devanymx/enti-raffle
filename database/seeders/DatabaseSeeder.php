<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Question::factory(300)->has(
            QuestionAnswer::factory(4)
        )->create();

        $user = User::factory()->create(['email' => 'edreiccb@gmail.com']);
        //Create base team
        $team = Team::factory()->create(['name' => 'Users', 'personal_team' => false, 'user_id' => $user->id]);
        $user->current_team_id = $team->id;
        $user->save();

        $user = User::factory()->create();
        $user->current_team_id = $team->id;
        $user->save();
        $user->teams()->attach($team, ['role' => 'user']);

        $user = User::factory()->create();
        $user->current_team_id = $team->id;
        $user->save();
        $user->teams()->attach($team, ['role' => 'user']);

        $user = User::factory()->create();
        $user->current_team_id = $team->id;
        $user->save();
        $user->teams()->attach($team, ['role' => 'user']);

        $user = User::factory()->create();
        $user->current_team_id = $team->id;
        $user->save();
        $user->teams()->attach($team, ['role' => 'user']);

        $user = User::factory()->create();
        $user->current_team_id = $team->id;
        $user->save();
        $user->teams()->attach($team, ['role' => 'user']);

    }
}

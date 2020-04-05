<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\User;
use App\Answer;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->where('votable_type','App\Question')->delete();

        $users=User::all();
        $usersCounts=$users->count();
        $votes=[-1,1]; //vote[0] = -1 downvote / [1] is upvote
        foreach(Question::all() as $question)
        {
            for($i=0; $i< rand(1,$usersCounts); $i++)
            {
                $user=$users[$i];
                $user->voteQuestion($question,$votes[rand(0,1)]);
            }
        }

        \DB::table('votables')->where('votable_type','App\Answer')->delete();

        $users=User::all();
        $usersCounts=$users->count();
        $votes=[-1,1]; //vote[0] = -1 downvote / [1] is upvote
        foreach(Answer::all() as $answer)
        {
            for($i=0; $i< rand(1,$usersCounts); $i++)
            {
                $user=$users[$i];
                $user->voteAnswer($answer,$votes[rand(0,1)]);
            }
        }
    }
}

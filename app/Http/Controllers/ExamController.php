<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\User;
use App\Models\UserExam;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;


class ExamController extends Controller
{

    public function showExam(){
        $user = Auth::user();
        $url = $_ENV['APP_URL'].'/verify/'.$user->uuid;
        //Do the permission check to avoid forbidden consults.
        $token = $this->checkPermissions('exam.show');
        if (!$token) return redirect()->route('forbidden');


        return view('exam.start',[
            'user' => $user,
            'url' => $url
        ]);

    }

    public function startRaffle(){
        $user = Auth::user();
        //Do the permission check to avoid forbidden consults.
        $token = $this->checkPermissions('exam.raffle');
        if (!$token) return redirect()->route('forbidden');

        $code = $user->raffleNumber;

        if ($code == null){
            $rand = File::query()
                ->where('type',$user->type)
                ->whereNull('user_id')
                ->inRandomOrder()
                ->first();

            $user->raffleNumber = $rand->name;
            $user->file()->save($rand);
            $user->save();

            $code = $rand->name;
        }


        return view('exam.show',[
            'code' => $code
        ]);

    }

    public function downloadCertificate($uuid){

        $user = User::where('uuid',$uuid)->limit(1)->get();
        $url = $_ENV['APP_URL'].'/verify/'.$uuid;

        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        $date = new Carbon('now');
        $nowDate = $date->isoFormat('MMMM Do YYYY, h:mm:ss a');

        $data = [
            'nowDate' => $nowDate,
            'url' => $url
        ];

        $pdf = PDF::loadView('exam.certificate', $data);

        return $pdf->download('Certificado de '.$user[0]->name.'.pdf');
    }

    public function downloadAuditory($uuid){
        $exam = UserExam::where('uuid',$uuid)->with('user')->first();
        $url = $_ENV['APP_URL'].'/verify/'.$uuid;
        $user = User::find($exam->user_id);

        $data = [
            'user' => $user,
            'exam' => $exam,
            'url' => $url,
            'questions' => $user->questions,
        ];

        $pdf = PDF::loadView('exam.auditory', $data);

        return $pdf->download('Certificado de '.$user->name.'.pdf');

    }

    public function checkPermissions($permission){
        $user = Auth::user();
        $currentTeam = $user->currentTeam;
        $perms = explode('.', $permission);
        $wildcard = '';
        for ($i = 0; $i < count($perms); $i++)  if ($user->hasTeamPermission($currentTeam, $perms[$i].'.*')) return true;
        else{ $wildcard .= $perms[$i].'.'; if ($user->hasTeamPermission($currentTeam, $wildcard.'*')) return true;}
        return $user->hasTeamPermission($currentTeam, $permission);
    }

}

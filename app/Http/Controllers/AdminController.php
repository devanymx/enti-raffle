<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Doctrine\DBAL\Driver\Middleware\AbstractConnectionMiddleware;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Monolog\Handler\IFTTTHandler;


class AdminController extends Controller
{
    /*
     *
     * */
    public function showDashboard(Request $request){

        //Do the permission check to avoid forbidden consults.
        $token = $this->checkPermissions('dashboard.show.table');
        if (!$token) return redirect()->route('forbidden');

        $team = Team::find(1);
        $users = $team->users()->where('confirmed','1')->paginate(4);

        //Check if the table has filters
        $filters = false;
        $isActiveFilters = $request->query('filter');
        if ($isActiveFilters) {
            $users = $team->users;
            $filters = true;
            $users = $this->filterData($users,$request);
        }


        return view('dashboard',[
            'users' => $users,
            'filters' => $filters
        ]);

    }

    public function addConfirmed(){
        return view('confirm',[
            'message' => ""
        ]);
    }

    public function confirmUser(Request $request){
        $input = $request->all();
        $code = $input['code'];

        $user = User::where('email',$code)->first();
        $user->confirmed = true;
        $user->save();

        return view('confirm',[
            'message' => "{$user->email} se ha registrado éxitosamente."
        ]);
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

    private function filterData($users,$request){
        $filterValues = $request->all();
        $filterKeys = array_keys($filterValues);
        foreach($filterKeys as $filterKey){
            if ($filterKey == 'score'){
                return $this->filterScore($users, $filterKey, $request);
            }
            if ($filterKey == 'text'){
                return $this->filterText($users, $filterKey, $request);
            }
        }
    }

    private function filterScore($users, $filterKey, $request){
        $team = Team::find(1);

        if ($request->query($filterKey) == 'civil'){
            $data = $team->users()->where('type',1)->where('confirmed',true)->paginate(5);
        }
        if ($request->query($filterKey) == 'penal'){
            $data = $team->users()->where('type',2)->where('confirmed',true)->paginate(5);
        }
        if ($request->query($filterKey) == 'none'){
            $data = $team->users()->where('confirmed',false)->paginate(5);
        }



        return $data;
    }

    private function filterText($users, $filterKey, $request){
        $team = Team::find(1);

        $filteredEmail = $team->users()->where('email',$request->query($filterKey))->paginate(5);
        if (count($filteredEmail) > 0) return $filteredEmail;
        $filteredName = $team->users()->where('name',$request->query($filterKey))->paginate(5);
        if (count($filteredName) > 0) return $filteredEmail;

        return [];

    }
}

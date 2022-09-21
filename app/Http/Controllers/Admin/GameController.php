<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameLog;
use App\Models\GuesseBonus;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(){
        $pageTitle = "Games";
        $games = Game::all();
        return view('admin.game.index',compact('pageTitle','games'));
    }

    public function headTail(){
        $pageTitle = "Head & Tails";
        $game = Game::find(1);
        return view('admin.game.headTail',compact('pageTitle','game'));
    }

    public function rockPaperScissors(){
        $pageTitle = "Rock Paper Scissors";
        $game = Game::find(2);
        return view('admin.game.rockPaperScissors',compact('pageTitle','game'));
    }

    public function diceRolling(){
        $pageTitle = "Dice Rolling";
        $game = Game::find(5);
        return view('admin.game.diceRolling',compact('pageTitle','game'));
    }

    public function cardFinding(){
        $pageTitle = "Card Finding";
        $game = Game::find(6);
        return view('admin.game.cardFinding',compact('pageTitle','game'));
    }

    public function spinWheel(){
        $pageTitle = "Spin Wheel";
        $game = Game::find(3);
        return view('admin.game.spinWheel',compact('pageTitle','game'));
    }

    public function numberPoll(){
        $pageTitle = "Number Pool";
        $game = Game::find(8);
        return view('admin.game.numberPoll',compact('pageTitle','game'));
    }

    public function numberSlot(){
        $pageTitle = "Number Slot";
        $game = Game::find(7);
        return view('admin.game.numberSlot',compact('pageTitle','game'));
    }

    public function update(Request $request,$id)
    {
    	$request->validate([
    		'name'=>'required',
    		'min'=>'required|numeric',
    		'max'=>'required|numeric',
            'instruction'=>'required',
            'win'=>'sometimes|required|numeric',
            'invest_back'=>'sometimes|required',
            'level.*'=>'sometimes|required',
            'chance.*'=>'sometimes|required|numeric'
    	],[
            'level.0.required'=>'Level 1 field is required',
            'level.1.required'=>'Level 2 field is required',
            'level.2.required'=>'Level 3 field is required',
            'chance.0.required'=>'No win chance field required',
            'chance.1.required'=>'Double win chance field is required',
            'chance.2.required'=>'Single win chance field is required',
            'chance.3.required'=>'Triple win field is required',
            'chance.*.numeric'=>'Chance field must be a number',
        ]);
        if (isset($request->probable) > 100) {
            $notify[] = ['error','The Winning Chance Must Be Less Than or Equal 100'];
            return back()->withNotify($notify);
        }
        $winChance = $request->probable;
        if (isset($request->chance)) {
            if(array_sum($request->chance) != 100){
                $notify[] = ['error','The Sum of Winning Chance Must Be Equal 100'];
                return back()->withNotify($notify);
            }
            $winChance = $request->chance;
        }
    	$game = Game::find($id);
    	$image = $game->image;
    	if ($request->hasFile('image')) {
    		try {
    			$image = uploadImage($request->image,imagePath()['game']['path'],imagePath()['game']['size'],$game->image);
    		} catch (Exception $e) {
    			$notify[] = ['error', 'Could not upload the Image.'];
                return back()->withNotify($notify);
    		}
    	}
    	$game->update([
    		'name'=>$request->name,
    		'min_limit'=>$request->min,
    		'max_limit'=>$request->max,
    		'image'=>$image,
    		'probable_win'=>$winChance,
    		'status'=>$request->status ? 1 : 0,
    		'invest_back'=>$request->invest_back ? 1 : 0,
            'instruction'=>$request->instruction,
            'level'=>$request->level,
            'win'=>$request->win,
    	]);
    	$notify[] = ['success','Game Updated successfully'];
    	return back()->withNotify($notify);
    }

    public function numberGuesse(){
        $pageTitle = "Number Guessing Game";
        $bon = GuesseBonus::get();
        $game = Game::find(4);
        return view('admin.game.guessing',compact('pageTitle','bon','game'));
    }

    public function gameLog(){
        $pageTitle = "Game Logs";
        $logs = GameLog::where('status',1)->with('user', 'game')->latest('id')->paginate(getPaginate());
        return view('admin.game.gameLog',compact('pageTitle','logs'));
    }

    public function chanceCreate(Request $request){
        $this->validate($request, [
            'chance*' => 'required|integer|min:1',
            'percent*' => 'required|numeric',
        ]);
        GuesseBonus::truncate();
        for ($a = 0; $a < count($request->chance); $a++){
            GuesseBonus::create([
                'chance' => $request->chance[$a],
                'percent' => $request->percent[$a],
                'status' => 1,
            ]);
        }
        $notify[] = ['success', 'Create Successfully'];
        return back()->withNotify($notify);
    }
}

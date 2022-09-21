<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameLog;
use App\Models\GuesseBonus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayController extends Controller
{
    /*
     * Head Tails
     */
    public function headTail()
    {
        $game = Game::find(1);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.headtails', compact('game', 'pageTitle'));

    }

    public function playheadTail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'choose' => 'required',
        ], [
            'choose.required' => 'please choose head or tail'
        ]);

        $user = auth()->user();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $game = Game::find(1);

        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }

        //check balance
        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        /// Check Max-min Limit
        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }


        //balance update
        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to head and tails',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,

        ]);

        $random = mt_rand(0, 100);
        if ($random <= $game->probable_win) {
            $win = 1;
            $result = $request->choose;
        } else {
            $win = 0;
            $result = $request->choose == 'head' ? 'tail' : 'head';
        }

        $gmLog = GameLog::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'user_select' => $request->choose,
            'result' => $result,
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
            'game_name' => 'head_tail',
        ]);

        $res['game_id'] = $gmLog->id;
        $res['balance'] = $user->balance;
        return response()->json($res);
    }

    public function gameEndHeadTail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find($gameLog->game_id);
        $trx = getTrx();

        if ($gameLog->win_status == 1) {
            $winBon = $gameLog->invest * $game->win / 100;
            $amo = $winBon;
            $investBack = 0;
            if ($game->invest_back == 1) {
                $investBack = $gameLog->invest;
                $user->balance += $gameLog->invest;
                $user->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $investBack,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Invest Back For Head Tail',
                    'remark' => 'invest_back',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
            $user->balance += $amo;
            $user->save();

            $gameLog->win_amo = $amo;
            $gameLog->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $winBon,
                'charge' => 0,
                'trx_type' => '+',
                'details' => 'Win bonus of head and tails',
                'remark' => 'Win_Bonus',
                'trx' => $trx,
                'post_balance' => $user->balance,

            ]);

            $res['result'] = $gameLog->result;
            $res['message'] = 'Yahho! You Win!!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['result'] = $gameLog->result;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;

        }
        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }

    /*
     * Rock Paper Scissor
     */
    public function rockPaperScissors(Request $request)
    {
        $game = Game::find(2);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.rockPaperScissors', compact('game', 'pageTitle'));
    }

    public function playrockPaperScissors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'choose' => 'required|in:rock,paper,scissors',
        ], [
            'choose.required' => 'please choose 1 from rock, paper and scissors'
        ]);

        $user = auth()->user();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $game = Game::find(2);

        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }

        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Rock Paper Scissors',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,

        ]);

        $userChoose = $request->choose;
        $random = mt_rand(0, 100);
        if ($random <= $game->probable_win) {
            $win = 1;
            if ($userChoose == 'rock') {
                $result = 'scissors';
            }
            if ($userChoose == 'paper') {
                $result = 'rock';
            }
            if ($userChoose == 'scissors') {
                $result = 'paper';
            }
        } else {
            $win = 0;
            if ($userChoose == 'rock') {
                $result = 'paper';
            }
            if ($userChoose == 'paper') {
                $result = 'scissors';
            }
            if ($userChoose == 'scissors') {
                $result = 'rock';
            }
        }

        $gmLog = GameLog::create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'user_select' => $request->choose,
            'result' => $result,
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
        ]);

        $res['game_id'] = $gmLog->id;
        $res['balance'] = $user->balance;
        return response()->json($res);

    }

    public function gameEndRockPaperScissors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find($gameLog->game_id);
        if ($gameLog->win_status == 1) {
            $winBon = $gameLog->invest * $game->win / 100;
            $amo = $winBon;
            $investBack = 0;
            $trx = getTrx();
            if ($game->invest_back == 1) {
                $investBack = $gameLog->invest;
                $user->balance += $gameLog->invest;
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $investBack,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Invest Back For Rock Paper Scissors',
                    'remark' => 'invest_back',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
            $user->balance += $amo;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $winBon,
                'charge' => 0,
                'trx_type' => '+',
                'details' => 'Win bonus of Rock Paper Scissors',
                'remark' => 'win_bonus',
                'trx' => $trx,
                'post_balance' => $user->balance,

            ]);

            $gameLog->win_amo = $winBon;
            $gameLog->save();

            $res['result'] = $gameLog->result;
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Yahho! You Win!!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['result'] = $gameLog->result;
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;

        }
        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }

    /*
     * Spin Wheel
     */
    public function spinWheel()
    {
        $game = Game::find(3);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.spinWheel', compact('game', 'pageTitle'));
    }

    public function playspinWheel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'choose' => 'required|in:blue,red',
        ], [
            'choose.required' => 'please choose Blue or Red'
        ]);

        $user = auth()->user();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $game = Game::find(3);

        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }


        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        /// Check Max-min Limit
        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Spin Wheel',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,
        ]);

        $random = mt_rand(0, 100);
        if ($random <= $game->probable_win) {
            $win = 1;
            $result = $request->choose;
        } else {
            $win = 0;
            $result = $request->choose == 'blue' ? 'red' : 'blue';
        }


        $gmLog = GameLog::create([
            'user_id' => auth()->user()->id,
            'game_id' => $game->id,
            'user_select' => $request->choose,
            'result' => $result,
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
        ]);

        $res['game_id'] = $gmLog->id;
        $res['invest'] = $request->invest;
        $res['result'] = $result;
        $res['balance'] = $user->balance;
        return response()->json($res);
    }

    public function gameEndSpinWheel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $user = auth()->user();

        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find($gameLog->game_id);
        if ($gameLog->win_status == 1) {
            $winBon = $gameLog->invest * $game->win / 100;
            $amo = $winBon;
            $investBack = 0;
            $trx = getTrx();
            if ($game->invest_back == 1) {
                $investBack = $gameLog->invest;
                $user->balance += $gameLog->invest;
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $investBack,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Invest Back For Spin Wheel',
                    'remark' => 'invest_back',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
            $user->balance += $amo;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $winBon,
                'charge' => 0,
                'trx_type' => '+',
                'details' => 'Win bonus of Spin Wheel',
                'remark' => 'win_bonus',
                'trx' => $trx,
                'post_balance' => $user->balance,
            ]);

            $gameLog->win_amo = $winBon;
            $gameLog->save();

            $res['result'] = $gameLog->result;
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Yahho! You Win!!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['result'] = $gameLog->result;
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;
        }



        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }

    /*
     * Number Guess
     */
    public function numberGuess()
    {
        $game = Game::find(4);
        $pageTitle = "Play " . $game->name;
        $gesBon = GuesseBonus::get();
        return view(activeTemplate() . 'user.games.numberGuess', compact('game', 'pageTitle', 'gesBon'));
    }

    public function playnumberGuess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $user = auth()->user();
        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        // Check Max-min Limit
        $game = Game::find(4);

        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }
        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Number Guessing Game',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,
        ]);

        $num = mt_rand(1, 100);
        $gmLog = GameLog::create([
            'user_id' => auth()->user()->id,
            'game_id' => $game->id,
            'result' => $num,
            'status' => 0,
            'win_status' => 0,
            'try' => 0,
            'invest' => $request->invest,
        ]);
        $res['game_id'] = $gmLog->id;
        $res['invest'] = $request->invest;
        $res['balance'] = $bal;
        return response()->json($res);
    }

    public function gameEndnumberGuess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
            'number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->number < 1 || $request->number > 100) {
            return response()->json(['error' => 'Enter a number between 1 and 100']);
        }
        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        if ($gameLog->user_select != null) {
            $userSelect = json_decode($gameLog->user_select);
            array_push($userSelect, $request->number);
        } else {
            $userSelect[] = $request->number;
        }
        $data = GuesseBonus::get();
        $count = $data->count();

        if ($gameLog->status == 1) {
            $mes['gameSt'] = 1;
            $mes['message'] = 'Time Over';
            return response()->json($mes);
        }

        $gameLog->try = $gameLog->try + 1;
        $gameLog->user_select = json_encode($userSelect);
        if ($gameLog->try >= $count) {
            $gameLog->status = 1;
        }
        $gameLog->save();

        $bonus = GuesseBonus::where('chance', $gameLog->try)->first()->percent;
        $amo = $gameLog->invest * $bonus / 100;

        $user = auth()->user();
        $game = Game::find($gameLog->game_id);

        $result = $gameLog->result;

        if ($request->number < $result) {
            $mes['message'] = 'The Number is short';
            $win = 0;
            $mes['type'] = 0;
        }
        if ($request->number > $result) {
            $mes['message'] = 'The Number is high';
            $win = 0;
            $mes['type'] = 1;
        }


        if ($gameLog->status == 1) {
            $mes['gameSt'] = 1;
            $mes['message'] = 'Oops You Lost! The Number was ' . $gameLog->result;
        } else {
            $nextBonus = GuesseBonus::find($gameLog->try + 1);
            $mes['data'] = $nextBonus->percent . '%';
        }

        if ($request->number == $result) {
            $gameLog->update([
                'win_status' => 1,
                'status' => 1,
                'win_amo' => $amo,

            ]);

            $user->balance += $amo;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $amo,
                'charge' => 0,
                'trx_type' => '+',
                'details' => $bonus . '% Bonus For Number Guessing Game',
                'remark' => 'Win_Bonus',
                'trx' => getTrx(),
                'post_balance' => $user->balance,

            ]);

            $mes['gameSt'] = 1;
            $mes['message'] = 'This is the number';
            $win = 1;
        }



        $mes['bal'] = $user->balance;
        return response()->json($mes);

    }

    /*
     * Dice Rolling
     */
    public function diceRolling()
    {
        $game = Game::find(5);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.diceRolling', compact('game', 'pageTitle'));

    }

    public function playdiceRoll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'choose' => 'required',
        ], [
            'choose.required' => 'please choose a dice'
        ]);

        $user = auth()->user();


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $game = Game::find(5);
        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }
        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Dice Rolling',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,

        ]);

        $random = mt_rand(0, 100);
        if ($random <= $game->probable_win) {
            $win = 1;
            $result = $request->choose;
        } else {
            $win = 0;
            for ($i = 0; $i < 100; $i++) {
                $randWin = rand(1, 6);
                if ($randWin != $request->choose) {
                    $result = $randWin;
                    break;
                }
            }
        }

        $gmLog = GameLog::create([
            'user_id' => auth()->user()->id,
            'game_id' => $game->id,
            'user_select' => $request->choose,
            'result' => $result,
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
        ]);

        $res['game_id'] = $gmLog->id;
        $res['result'] = $result;
        $res['balance'] = $user->balance;
        return response()->json($res);
    }

    public function gameEnddiceRoll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find(5);
        if ($gameLog->win_status == 1) {
            $winBon = $gameLog->invest * $game->win / 100;
            $amo = $winBon;
            $investBack = 0;
            $trx = getTrx();
            if ($game->invest_back == 1) {
                $investBack = $gameLog->invest;
                $amo = $winBon + $gameLog->invest;
                $user->balance += $gameLog->invest;
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $investBack,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Invest Back For Dice Rolling',
                    'remark' => 'invest_back',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
            $user->balance += $amo;
            $user->save();

            $gameLog->win_amo = $amo;
            $gameLog->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $winBon,
                'charge' => 0,
                'trx_type' => '+',
                'details' => 'Win bonus of Dice Rolling',
                'remark' => 'Win_Bonus',
                'trx' => $trx,
                'post_balance' => $user->balance,

            ]);

            $res['result'] = $gameLog->result;
            $res['message'] = 'Yahho! You Win!!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['result'] = $gameLog->result;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;

        }
        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }

    /*
     * Card Finding
     */
    public function cardFinding()
    {
        $game = Game::find(6);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.cardFinding', compact('game', 'pageTitle'));

    }

    public function playCardFinding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'choose' => 'required|in:black,red',
        ], [
            'choose.required' => 'please choose Black or Red'
        ]);

        $user = auth()->user();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $game = Game::find(6);

        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }

        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        /// Check Max-min Limit
        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Card Finding Game',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,

        ]);

        $random = mt_rand(0, 100);
        if ($random <= $game->probable_win) {
            $win = 1;
            $result = $request->choose;
        } else {
            $win = 0;
            $result = $request->choose == 'black' ? 'red' : 'black';
        }

        $gmLog = GameLog::create([
            'user_id' => auth()->user()->id,
            'game_id' => $game->id,
            'user_select' => $request->choose,
            'result' => $result,
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
        ]);

        $res['game_id'] = $gmLog->id;
        $res['result'] = $result;
        $res['balance'] = $user->balance;
        return response()->json($res);
    }

    public function gameEndCardFinding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find($gameLog->game_id);
        if ($gameLog->win_status == 1) {
            $winBon = $gameLog->invest * $game->win / 100;
            $amo = $winBon;
            $investBack = 0;
            $trx = getTrx();
            if ($game->invest_back == 1) {
                $investBack = $gameLog->invest;
                $amo = $winBon + $gameLog->invest;
                $user->balance += $gameLog->invest;
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $investBack,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Invest Back For Card Finding Game',
                    'remark' => 'invest_back',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
            $user->balance += $amo;
            $user->save();

            $gameLog->win_amo = $amo;
            $gameLog->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $winBon,
                'charge' => 0,
                'trx_type' => '+',
                'details' => 'Win bonus of Card Finding Game',
                'remark' => 'win_bonus',
                'trx' => $trx,
                'post_balance' => $user->balance,

            ]);
            $res['result'] = $gameLog->result;
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Yahho! You Win!!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['result'] = $gameLog->result;
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;
        }
        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }

    /*
     * Number Slot
     */
    public function numberSlot()
    {
        $game = Game::find(7);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.numberSlot', compact('game', 'pageTitle'));
    }

    public function PlayNumberSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $myNum = $request->number;
        if ($myNum < 0 || $myNum > 9) {
            return response()->json(['error' => 'Invalide selection']);
        }
        $user = auth()->user();
        $game = Game::find(7);
        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }
        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        // Check Max-min Limit
        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Number Slotting Game',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,

        ]);

        $random = mt_rand(1, 100);

        if($game->probable_win[0] > $random){
            $result = numberSlotResult(0,$request->number);
            $win = 0;
        }elseif ($game->probable_win[0]+$game->probable_win[1] > $random) {
            $result = numberSlotResult(1,$request->number);
            $win = 1;
        }elseif ($game->probable_win[0]+$game->probable_win[1]+$game->probable_win[3] > $random) {
            $result = numberSlotResult(2,$request->number);
            $win = 2;
        }else{
            $result = numberSlotResult(3,$request->number);
            $win = 3;
        }

        $gmLog = GameLog::create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'user_select' => $myNum,
            'result' => json_encode($result),
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
        ]);

        $res['game_id'] = $gmLog->id;
        $res['number'] = $result;
        $res['win'] = $win;
        $res['balance'] = $user->balance;
        return response()->json($res);
    }

    public function gameEndnumberSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find($gameLog->game_id);
        $winner = 0;
        $trx = getTrx();

        foreach ($game->level as $key => $data) {
            if ($gameLog->win_status == $key + 1) {
                $winBon = $gameLog->invest * $game->level[$key] / 100;
                $amo = $winBon;
                $user->balance += $amo;
                $user->save();

                $gameLog->win_amo = $amo;
                $gameLog->save();

                $winner = 1;
                $lev = $key + 1;

                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $winBon,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => $game->level[$key] . '% Win bonus of Number Slot Game ' . $lev . ' Time',
                    'remark' => 'win_bonus',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
        }
        if ($winner == 1) {
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Yahho! You Win for ' . $gameLog->win_status . ' Time !!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['user_choose'] = $gameLog->user_select;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;
        }

        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }

    /*
     * Pool Number
     */
    public function poolNumber()
    {
        $game = Game::find(8);
        $pageTitle = "Play " . $game->name;
        return view(activeTemplate() . 'user.games.poolNumber', compact('game', 'pageTitle'));
    }

    public function playPoolNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invest' => 'required|numeric|gt:0',
            'choose' => 'required',
        ], [
            'choose.required' => 'please choose a ball'
        ]);

        $user = auth()->user();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $game = Game::find(8);

        $running = GameLog::where('status',0)->where('user_id',$user->id)->where('game_id',$game->id)->first();
        if ($running) {
            return response()->json(['error' => '1 game is in-complete. Please wait']);
        }

        if ($request->invest > $user->balance) {
            return response()->json(['error' => 'Oops! You have no sufficient balance']);
        }

        if ($request->invest > $game->max_limit) {
            return response()->json(['error' => 'Please follow the maximum limit of invest']);
        }

        if ($request->invest < $game->min_limit) {
            return response()->json(['error' => 'Please follow the minimum limit of invest']);
        }

        $bal = $user->balance - $request->invest;
        $user->update(['balance' => $bal]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->invest,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Invest to Pool Number',
            'remark' => 'invest',
            'trx' => getTrx(),
            'post_balance' => $bal,

        ]);


        $random = mt_rand(0, 100);
        $result = 8;
        if ($random <= $game->probable_win) {
            $win = 1;
            $result = $request->choose;
        } else {
            $win = 0;
            for ($i = 0; $i < 100; $i++) {
                $randWin = rand(1, 8);
                if ($randWin != $request->choose) {
                    $result = $randWin;
                    break;
                }
            }
        }


        $gmLog = GameLog::create([
            'user_id' => auth()->user()->id,
            'game_id' => $game->id,
            'user_select' => $request->choose,
            'result' => $result,
            'status' => 0,
            'win_status' => $win,
            'invest' => $request->invest,
        ]);

        $res['game_id'] = $gmLog->id;
        $res['invest'] = $request->invest;
        $res['result'] = $result;
        $res['win'] = $win;
        $res['balance'] = $user->balance;
        return response()->json($res);
    }

    public function gameEndPoolNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $gameLog = GameLog::where('user_id',$user->id)->where('id',$request->game_id)->first();
        if (!$gameLog) {
            return response()->json(['error' => 'Game Logs not found']);
        }
        $game = Game::find($gameLog->game_id);
        if ($gameLog->win_status == 1) {
            $winBon = $gameLog->invest * $game->win / 100;
            $amo = $winBon;
            $investBack = 0;
            $trx = getTrx();
            if ($game->invest_back == 1) {
                $investBack = $gameLog->invest;
                $amo = $winBon + $gameLog->invest;
                $user->balance += $gameLog->invest;
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $investBack,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Invest Back For Pool Number',
                    'remark' => 'invest_back',
                    'trx' => $trx,
                    'post_balance' => $user->balance,

                ]);
            }
            $user->balance += $amo;
            $user->save();

            $gameLog->win_amo = $amo;
            $gameLog->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $winBon,
                'charge' => 0,
                'trx_type' => '+',
                'details' => 'Win bonus of Pool Number',
                'remark' => 'Win_Bonus',
                'trx' => $trx,
                'post_balance' => $user->balance,

            ]);
            $res['result'] = $gameLog->result;
            $res['message'] = 'Yahho! You Win!!!';
            $res['type'] = 'success';
            $res['bal'] = $user->balance;
        } else {
            $res['result'] = $gameLog->result;
            $res['message'] = 'Oops! You Lost!!';
            $res['type'] = 'danger';
            $res['bal'] = $user->balance;

        }
        $gameLog->update(['status' => 1]);
        return response()->json($res);
    }
}
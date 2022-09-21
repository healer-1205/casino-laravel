<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ManualGatewayController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manual Gateways';
        $gateways = Gateway::manual()->orderBy('id','desc')->get();
        $emptyMessage = 'No manual methods available.';
        return view('admin.gateway_manual.list', compact('pageTitle', 'gateways','emptyMessage'));
    }

    public function create()
    {
        $pageTitle = 'New Manual Gateway';
        return view('admin.gateway_manual.create', compact('pageTitle'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'name'           => 'required|max:60',
            'image'          => ['required','image',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'rate'           => 'required|numeric|gt:0',
            'currency'       => 'required|max:10',
            'min_limit'      => 'required|numeric|gt:0',
            'max_limit'      => 'required|numeric|gt:'.$request->min_limit,
            'fixed_charge'   => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|between:0,100',
            'instruction'    => 'required|max:64000',
            'field_name.*'   => 'sometimes|required'
        ],[
            'field_name.*.required'=>'All field is required',
        ]);
        $lastMethod = Gateway::manual()->orderBy('id','desc')->first();
        $methodCode = 1000;
        if ($lastMethod) {
            $methodCode = $lastMethod->code + 1;
        }

        $filename = '';
        $path = imagePath()['gateway']['path'];
        $size = imagePath()['gateway']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }


        $inputForm = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', trim($request->field_name[$a])));
                $arr['field_level'] = trim($request->field_name[$a]);
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $inputForm[$arr['field_name']] = $arr;
            }
        }
        $method = new Gateway();
        $method->code = $methodCode;
        $method->name = $request->name;
        $method->alias = strtolower(trim(str_replace(' ','_',$request->name)));
        $method->image = $filename;
        $method->status = 0;
        $method->parameters = json_encode([]);
        $method->input_form = $inputForm;
        $method->supported_currencies = json_encode([]);
        $method->crypto = 0;
        $method->description = $request->instruction;
        $method->save();

        $method->single_currency()->save(new GatewayCurrency([
            'name' => $request->name,
            'gateway_alias' => strtolower(trim(str_replace(' ','_',$request->name))),
            'currency' => $request->currency,
            'symbol' => '',
            'min_amount' => $request->min_limit,
            'max_amount' => $request->max_limit,
            'fixed_charge' => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'rate' => $request->rate,
            'image' => $filename,
            'gateway_parameter' => json_encode($inputForm),
        ]));

        $notify[] = ['success', $method->name . ' Manual gateway has been added.'];
        return back()->withNotify($notify);
    }

    public function edit($alias)
    {
        $pageTitle = 'New Manual Gateway';
        $method = Gateway::manual()->with('single_currency')->where('alias', $alias)->firstOrFail();
        return view('admin.gateway_manual.edit', compact('pageTitle', 'method'));
    }

    public function update(Request $request, $code)
    {
        $request->validate([
            'name'           => 'required|max: 60',
            'image'          => [
                'nullable',
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])
            ],
            'rate'           => 'required|numeric|gt:0',
            'currency'       => 'required',
            'min_limit'      => 'required|numeric|gt:0',
            'max_limit'      => 'required|numeric|gt:'.$request->min_limit,
            'fixed_charge'   => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|between:0,100',
            'instruction'    => 'required|max:64000',
            'field_name.*'    => 'sometimes|required'
        ],[
            'field_name.*.required'=>'All field is required',
        ]);
        $method = Gateway::manual()->where('code', $code)->firstOrFail();

        $filename = $method->image;

        $path = imagePath()['gateway']['path'];
        $size = imagePath()['gateway']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', trim($request->field_name[$a])));
                $arr['field_level'] = trim($request->field_name[$a]);
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        $method->name = $request->name;
        $method->alias = strtolower(trim(str_replace(' ','_',$request->name)));
        $method->image = $filename;
        $method->parameters = json_encode([]);
        $method->supported_currencies = json_encode([]);
        $method->crypto = 0;
        $method->description = $request->instruction;
        $method->input_form = $input_form;
        $method->save();


        $single_currency = $method->single_currency;

        $single_currency->name = $request->name;
        $single_currency->gateway_alias = strtolower(trim(str_replace(' ','_',$method->name)));
        $single_currency->currency = $request->currency;
        $single_currency->symbol = '';
        $single_currency->min_amount = $request->min_limit;
        $single_currency->max_amount = $request->max_limit;
        $single_currency->fixed_charge = $request->fixed_charge;
        $single_currency->percent_charge = $request->percent_charge;
        $single_currency->rate = $request->rate;
        $single_currency->image = $filename;
        $single_currency->gateway_parameter = json_encode($input_form);
        $single_currency->save();

        $notify[] = ['success', $method->name . ' Manual gateway has been updated.'];
        return redirect()->route('admin.gateway.manual.edit',[$method->alias])->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $method = Gateway::where('code', $request->code)->firstOrFail();
        $method->status = 1;
        $method->save();
        $notify[] = ['success', $method->name . ' has been activated.'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $method = Gateway::where('code', $request->code)->firstOrFail();
        $method->status = 0;
        $method->save();
        $notify[] = ['success', $method->name . ' has been deactivated.'];
        return back()->withNotify($notify);
    }
}

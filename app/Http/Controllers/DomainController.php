<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    public function index()
    {
        $domains = DB::table('domains')->get();

        return view('domain.index', compact('domains'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')->find($id);

        return view('domain.show', compact('domain'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|url'
        ]);

        foreach ($validator->errors()->all() as $message) {
            flash($message)->error();
        }

        $validator->validate();
        $validatedData = $validator->validated();
        $normalizedUrl = Domain::normalizeUrl($validatedData['name']);
        $currentDate = Carbon::now();

        $domain = DB::table('domains')->where('name', $normalizedUrl)->first();

        if ($domain) {
            DB::table('domains')->where('name', $normalizedUrl)->update(['updated_at' => $currentDate]);
            flash("Domain '$normalizedUrl' already exists!")->success();
        } else {
            $timestamps = [
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ];

            DB::table('domains')->insert(array_merge($validatedData, $timestamps));
            flash("Domain '$normalizedUrl' successfully added!")->success();
        }

        $id = DB::table('domains')->where('name', $normalizedUrl)->value('id');
        return redirect()->route('domains.show', compact('id'));
    }
}

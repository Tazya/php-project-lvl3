<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
use App\DomainCheck;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    public function index()
    {
        $domains = DB::table('domains')
            ->addSelect(['last_check_created_at' => DB::table('domain_checks')
                ->select('created_at')
                ->whereColumn('domain_id', 'domains.id')
                ->latest()
                ->take(1)
            ])
            ->addSelect(['last_check_status_code' => DB::table('domain_checks')
                ->select('status_code')
                ->whereColumn('domain_id', 'domains.id')
                ->latest()
                ->take(1)
            ])
            ->get();

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
            $id = $domain->id;
            flash("Domain '$normalizedUrl' already exists!")->success();
        } else {
            $timestamps = [
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ];

            $id = DB::table('domains')->insertGetId(array_merge($validatedData, $timestamps));

            DomainCheck::makeCheck($id);
            flash("Domain '$normalizedUrl' successfully added!")->success();
        }
        return redirect()->route('domains.show', compact('id'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
            ->paginate(20);

        return view('domain.index', compact('domains'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')->find($id);

        $domainChecks = DB::table('domain_checks')
            ->where('domain_id', $id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('domain.show', compact('domain', 'domainChecks'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Url is required',
            'name.url' => 'Not a valid url',
        ];

        $data = $this->validate($request, [
            'name' => 'required|url'
        ], $messages);

        $urlComponents = parse_url($data['name']);
        $normalizedUrl = "{$urlComponents['scheme']}://{$urlComponents['host']}";

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

            $id = DB::table('domains')->insertGetId(array_merge($data, $timestamps));
            flash("Domain '$normalizedUrl' successfully added!")->success();
        }

        return redirect()->route('domains.show', compact('id'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DomainCheckController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->validate($request, [
                'domain_id' => ['required', Rule::exists('domains', 'id')],
            ]);

            $domainChecks = DB::table('domain_checks')
                ->where('domain_id', $data['domain_id'])
                ->orderByDesc('created_at')
                ->paginate(20);

            return view('domain-check.index', compact('domainChecks'))->render();
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $this->validate($request, [
                'domain_id' => ['required', Rule::exists('domains', 'id')],
            ]);

            $currentDate = Carbon::now();
            $timestamps = [
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ];

            DB::table('domain_checks')->insert(array_merge($validatedData, $timestamps));

            return response("Domain checked!", 200);
        }
    }
}

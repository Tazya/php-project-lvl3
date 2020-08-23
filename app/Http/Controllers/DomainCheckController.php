<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\DomainCheck;

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
                ->paginate(10);

            return view('domain-check.index', compact('domainChecks'))->render();
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $this->validate($request, [
                'domain_id' => ['required', Rule::exists('domains', 'id')],
            ]);

            $domainId = $validatedData['domain_id'];

            DomainCheck::makeCheck($domainId);
            return response("Domain checked!", 200);
        }
    }
}

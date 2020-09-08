<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DomainCheck;

class DomainCheckController extends Controller
{
    public function store($id)
    {
        DomainCheck::makeCheck($id);
        flash("Website has been checked!")->success();

        return redirect()->route('domains.show', compact('id'));
    }
}

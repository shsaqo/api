<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Http\Resources\GetResource;
use App\Http\Traits\ResponseJson;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DomainController extends Controller
{

    public function index()
    {
        if (! Gate::allows('domain-show')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $domain = Domain::all();
        return new GetResource($domain);
    }


    public function store(DomainRequest $request)
    {
        if (! Gate::allows('domain-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $domain = Domain::create($request->validated());
        return new GetResource($domain);
    }


    public function update(DomainRequest $request, Domain $domain)
    {
        if (! Gate::allows('domain-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $domain->update($request->only('status'));
        return new GetResource($domain);
    }


    public function destroy(Domain $domain)
    {
        if (! Gate::allows('domain-full')) {
            return ResponseJson::response([], 403, 'permission denied');
        }
        $domain->delete();
        return new GetResource([]);
    }
}

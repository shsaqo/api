<?php

namespace App\Http\Controllers;

use App\Http\Requests\CodeRequest;
use App\Http\Resources\GetResource;
use App\Models\Code;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function index()
    {
        return new GetResource(Code::all());
    }

    public function frontIndex()
    {
        return new GetResource(Code::all());
    }

    public function store(CodeRequest $request)
    {
        $code = Code::create($request->all());
        return new GetResource($code);
    }

    public function show(Code $code)
    {
        return new GetResource($code);
    }

    public function update(CodeRequest $request, Code $code)
    {
        $code->update($request->all());
        return new GetResource($code);
    }

    public function destroy(Code $code)
    {
        $code->delete();
        return new GetResource($code);
    }
}

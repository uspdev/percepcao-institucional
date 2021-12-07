<?php

namespace App\Http\Controllers;

use App\Http\Requests\PercepcaoRequest;
use App\Models\Percepcao;

class PercepcaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $percepcoes = Percepcao::all();

        return view('percepcao.index', [
            'percepcoes' => $percepcoes,
            'percepcao' => new Percepcao,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $percepcao = new Percepcao;
        return view('percepcao.create', [
          'percepcao' => $percepcao,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PercepcaoRequest $request)
    {
        $validated = $request->validated();
        $percepcao = Percepcao::create($validated);

        return redirect(url('/percepcao-institucional/gestao-sistema/percepcao'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PercepcaoRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

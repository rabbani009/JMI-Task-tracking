<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use App\Models\Sbu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SbuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commons['page_title'] = 'Sbus';
        $commons['content_title'] = 'List of All Sbus';
        $commons['main_menu'] = 'sbu';
        $commons['current_menu'] = 'sbu';

        $sbus = Sbu::where('status', 1)->with(['createdBy', 'updatedBy'])->paginate(20);
        //dd($commons);
        return view('backend.pages.sbu.index',
            compact(
                'commons',
                'sbus'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouncilStoreRequest $request)
    {
       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commons['page_title'] = 'sbus';
        $commons['content_title'] = 'Show Sbus';
        $commons['main_menu'] = 'sbu';
        $commons['current_menu'] = 'sbu';

        $sbu = Sbu::findOrFail($id);
        $sbu = Sbu::where('status', 1)->with(['createdBy', 'updatedBy'])->paginate(20);

        return view('backend.pages.Sbu.show',
            compact(
                'commons',
              
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouncilUpdateRequest $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       

    }
}

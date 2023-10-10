<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use App\Models\Sbu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SbuStoreRequest;
use App\Http\Requests\SbuUpdateRequest;

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
        $commons['main_menu'] = 'sbu1';
        $commons['current_menu'] = 'page_sbu';

        $sbus = Sbu::where('status', 1)
        ->with(['createdBy', 'updatedBy'])
        ->orderBy('created_at', 'desc') // Order by created timestamp in descending order
        ->paginate(7);

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
        $commons['page_title'] = 'Sbus';
        $commons['content_title'] = 'Create Sbus';
        $commons['main_menu'] = 'sbu_create';
        $commons['current_menu'] = 'create_sbu';

        return view('backend.pages.sbu.create',
        compact(
            'commons'
        )
    );

       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SbuStoreRequest $request)
    {
        $sbu = new Sbu();
        $sbu->name = $request->validated('name');
        $sbu->slug = strtolower(str_replace(' ', '_', $request->validated('name')));
        $sbu->status = 1;
        $sbu->created_at = Carbon::now();
        $sbu->created_by = Auth::user()->id;
        $sbu->save();

        if ($sbu->wasRecentlyCreated){
            return redirect()
                ->route('sbu.index')
                ->with('success', 'sbu created successfully!');
        }

        return redirect()
            ->back()
            ->with('failed', 'sbu cannot be created!');

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
        $commons['page_title'] = 'Sbu';
        $commons['content_title'] = 'Edit Sbu';
        $commons['main_menu'] = 'sbu';
        $commons['current_menu'] = 'sbu_create';

        $sbu = Sbu::findOrFail($id);

        return view('backend.pages.sbu.edit',
            compact(
                'commons',
                'sbu',
 
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(sbuUpdateRequest $request, $id)
    {
        $sbu = Sbu::findOrFail($id);
        $sbu->name = $request->validated('name');
        $sbu->slug = strtolower(str_replace(' ', '_', $request->validated('name')));
        $sbu->status = $request->validated('status');
        $sbu->updated_at = Carbon::now();
        $sbu->updated_by = Auth::user()->id;
        $sbu->save();

        if ($sbu->getChanges()){
            return redirect()
                ->route('sbu.index')
                ->with('success', 'Sbu updated successfully!');
        }

        return redirect()
            ->back()
            ->with('failed', 'Sbu cannot be updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sbu = Sbu::findOrFail($id);
        $sbu->status = 0;
        $sbu->deleted_at = Carbon::now();
        $sbu->deleted_by = Auth::user()->id;
        $sbu->save();

        if ($sbu->getChanges()){
            return redirect()
                ->route('sbu.index')
                ->with('success', 'Sbu deleted successfully!');
        }

        return redirect()
            ->back()
            ->with('failed', 'Sbu cannot be deleted!');

    }
}

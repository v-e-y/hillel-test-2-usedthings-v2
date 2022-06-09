<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ad.list', [
            'ads' => Advertisement::orderBy('updated_at', 'desc')->paginate(5)
        ]);
    }

    /*
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ad.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\StoreAdvertisementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvertisementRequest $request)
    {
        if (
            $id = Auth::user()
                ->advertisements()
                ->create($request->validated())
                ->id
        ) {
            return redirect(route('ad.show', (int)$id), 201);
        };

        return back()->withErrors(['msg' => 'Some error(s) when saved']);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('ad.show', [
            'ad' => Advertisement::getAd($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        return view('ad.create', [
            'ad' => $advertisement
        ]);
    }

    /**
     * @param  \App\Http\Requests\StoreAdvertisementRequest  $request
     * @param Advertisement $advertisement
     * @return void
     */
    public function update(StoreAdvertisementRequest $request, Advertisement $advertisement)
    {
        if (
            Advertisement::where('id', $advertisement->id)
                ->update($request->validated())
        ) {
            return redirect()->route('ad.show', $advertisement->id, 201);
        };

        return back()->withErrors(['msg' => 'Some error(s) when editing']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Advertisement $advertisement)
    {
        if (Advertisement::destroy($advertisement->id)) {
            return redirect()->route('ad.index');
        }
        return back()->withErrors(['msg' => 'Some error(s) when deleting']);
    }
}

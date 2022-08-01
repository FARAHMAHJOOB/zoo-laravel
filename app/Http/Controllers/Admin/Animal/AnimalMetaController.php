<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Animal\Animal;
use App\Http\Controllers\Controller;
use App\Models\Admin\Animal\AnimalMeta;

class AnimalMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Animal $animal)
    {
        $flag = DB::transaction(function () use ($request, $animal) {
            $metas = array_combine($request->meta_key, $request->meta_value);
            foreach ($metas as $key => $value) {
                if ($key !== null && $value !== null) {
                    $meta = AnimalMeta::create([
                        'meta_key' => $key,
                        'meta_value' => $value,
                        'animal_id' => $animal->id
                    ]);
                }
            }
            return true;
        });
        if ($flag) {
            return redirect()->route('admin.animal.edit',  $animal->id)->with('swal-success', 'ویژگی(ها) با موفقیت ایجاد گردید');
        }
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
    public function update(Request $request, AnimalMeta $meta)
    {
        $result = $meta->update($request->all());
        return $result == true ? response()->json(['status' => true]) : response()->json(['status' => false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnimalMeta $meta)
    {
        $meta->delete();
        return redirect()->route('admin.animal.edit', $meta->animal->id)->with('swal-success', 'ویژگی با موفقیت حذف شد');

    }
}

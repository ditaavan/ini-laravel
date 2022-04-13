<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function kantor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'poisis' => 'required|max:100',
            'jk' => 'required|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }
        $validated = $validator->validated();

        Pegawai::create([
            'nama' => $validated['nama'],
            'poisis' => $validated['poisis'],
            'jk' => $validated['jk']
        ]);

        return response()->json('data berhasil disimpan')->setStatusCode(201);
    }

    public function show()
    {
        $pegawai = Pegawai::all();

        return response()->json($pegawai)->setStatusCode(200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'poisis' => 'required|max:100',
            'jk' => 'required|max:100'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $validated = $validator->validated();

        // dd($checkData);

        $checkData = Pegawai::find($id);
        if ($checkData) {

            Pegawai::where('id', $id)
                ->update([
                    'nama' => $validated['nama'],
                    'poisis' => $validated['poisis'],
                    'jk' => $validated['jk']
                ]);
            return response()->json([
                'messages' => 'Data berhasil disunting'
            ])->setStatusCode(201);
        }

        return response()->json([
            'messages' => 'Data pegawai tidak ditemukan'
        ])->setStatusCode(404);
    }

    public function destory($id)
    {
        $checkData = Pegawai::find($id);
        if ($checkData) {
            Pegawai::destory($id);

            return response()->json([
                'messages' => 'Data pegawai dihapus'
            ])->setStatusCode(200);
        }
        return response()->json([
            'messages' => 'Data pegawai tidak ditemukan'
        ])->setStatusCode(404);
    }
}

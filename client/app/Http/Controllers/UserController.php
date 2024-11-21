<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index(): View
    {
        // get users API dari server
        $send_request = Http::get('http://localhost:8000/api/v1/users');

        // membuat json menjadi array
        $response = $send_request->json('data');

        // memanggil view user,
        // users merupakan nama folder
        // index merupakan file index.blade.php yang ada didalam folder php
        return view('users.index', ['data' => $response]);
    }

    public function create()
    {
        $data = array();
        return view('users.create', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        // validate form
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'house_number' => 'required',
            'phone_number' => ' required',
            'city' => 'required',
            'roles' => 'required',
        ]);

        $send_request = Http::post('http://localhost:8000/api/v1/users', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'address' => $request->address,
            'house_number' => $request->house_number,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'roles' => $request->roles
        ]);

        $response = $send_request->json();
        if ($response['success'] === true) {
            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('users.index')->with(['eror' => 'Data Gagal Disimpan!']);
        }
    }

    public function show(string $id): View
    {
        // request get user dengan parameter ID ke server
        $response = Http::get("http://localhost:8000/api/v1/users/{$id}");

        // membuat notifikasi dari respon yang dihasilkan
        if ($response['success'] === true) {
            $dt = $response->json()['data'];
            return view('users.show', compact('dt'));
        } else {
            return redirect()->route('users.index')->with(['eror' => 'Data Tidak Ditemukan!']);
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            //validate form
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'phone_number' => 'required',
                'city' => 'required',
                'roles' => 'required',
            ]);

            // request ke server menggunakan PATCH
            $send_request = Http::asForm()->patch("http://localhost:8000/api/v1/users/{$id}", [
                '_method' => 'PATCH', // Tambahkan ini untuk method spoofing
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'city' => $request->city,
                'roles' => $request->roles
            ]);

            if (!$send_request->successful()) {
                throw new \Exception('Gagal mengupdate data');
            }

            $response = $send_request->json();

            if ($response['success'] === true) {
                return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
            }

            return redirect()->route('users.index')->with(['error' => 'Data Gagal Disimpan!']);
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id): RedirectResponse
    {
        //delete user by ID
        $response = Http::delete("http://localhost:8000/api/v1/users/{$id}");

        if ($response['success'] === true) {
            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('users.index')->with(['eror' => 'Data Gagal Disimpan!']);
        }
    }
}

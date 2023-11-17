<?php

namespace App\Http\Controllers;
// mengimport model Employees
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // menggunakan model Employees untuk select data
        $employees = Employees::all();

        // jika data dalam variabel employees kosong
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Data is empty',
                'data' => $employees
            ];
            // mengirim data (json) dan kode 200
            return response()->json($data, 200);
        }

        // jika terdapat data dalam variabel employees
        $data = [
            'message' => 'Get all Resource',
            'data' => $employees
        ];

        // mengirim data (json) dan kode 404
        return response()->json($data, 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data request
        $validatedData = $request->validate([
            "name" => "required",
            "gender" => "required",
            "phone" => "required|numeric",
            "address" => "required",
            "email" => "required|email",
            "status" => "required",
            "hired_on" => "required"

        ]);

        // menggunakan model Employees untuk membuat data baru
        $employees = Employees::create($validatedData);

        $data = [
            'message' => 'Resource is added succesfully',
            'data' => $employees
        ];

        // mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // cari id Employees yang ingin didapatkan
        $employees = Employees::find($id);

        // jika terdapat id pada employees
        if ($employees) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 200
            return response()->json($data, 200);

            // jika tidak ditemukan idnya
        } else {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // mencari data Employees sesuai id yang di tentukan
        $employees = Employees::find($id);

        // jika sesuai dengan id yang ditentukan akan membuat kondisi pada data dibawah
        if ($employees) {
            $input = [
                'name' => $request->name ?? $employees->name,
                'gender' => $request->gender ?? $employees->gender,
                'phone' => $request->phone ?? $employees->phone,
                'address' => $request->address ?? $employees->address,
                'email' => $request->email ?? $employees->email,
                'status' => $request->status ?? $employees->status,
                'hired_on' => $request->hired_on ?? $employees->hired_on,
            ];
            // menampilkan seluruh data employees dengan perubahan terbarunya
            $employees->update($input);

            $data = [
                'message' => 'Resource is update succesfully',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // mencari data employees sesuai id yang di tentukan
        $employees = Employees::find($id);

        if ($employees) {
            // delete id yang di tentukan
            $employees->delete();

            $data = [
                'message' => 'Resource is delete succesfully',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function search($name)
    {
        // cari name sesuai apa yang anda inginkan
        $employees = Employees::where('name', 'like', '%' . $name . '%')->get();

        // jika terdapat id pada employees
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);

            // jika tidak ditemukan idnya
        }
        $data = [
            'message' => 'Get Searched Resource',
            'data' => $employees
        ];

        // mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function active()
    {
        // cari name sesuai apa yang anda inginkan
        $employees = Employees::where('status', 'aktif')->get();

        // jika tidak ditemukan
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);
        }
        // jika terdapat status aktif pada employees
        $data = [
            'message' => 'Get Active Resource',
            'data' => $employees
        ];
        // mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function inactive()
    {
        // cari name sesuai apa yang anda inginkan
        $employees = Employees::where('status', 'tidak aktif')->get();

        // jika tidak ditemukan
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);
        }
        // jika terdapat status tidak aktif pada employees
        $data = [
            'message' => 'Get Inactive Resource',
            'data' => $employees
        ];
        // mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function terminated()
    {
        // cari name sesuai apa yang anda inginkan
        $employees = Employees::where('status', 'dihentikan')->get();

        // jika tidak ditemukan
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);
        }
        // jika terdapat status dihentikan pada employees
        $data = [
            'message' => 'Get Terminated Resource',
            'data' => $employees
        ];
        // mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }
}

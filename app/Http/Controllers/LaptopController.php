<?php

namespace App\Http\Controllers;

use App\Http\Requests\Laptop\StoreLaptopRequest;
use App\Http\Requests\Laptop\UpdateLaptopRequest;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $laptop = Laptop::get();

            $response = [
                'message' => 'Get All Laptop Success',
                'length' => count($laptop),
                'data' => $laptop
            ];

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaptopRequest $request)
    {
        try {
            $data = $request->validated();

            if($request->has('picture')) {
                foreach($request->file('picture') as $image) {
                    $filename = Str::random(32).".".$image->getClientOriginalExtension();
                    $image->move('uploads/', $filename);
    
                    $laptop = Laptop::create([
                        'serial_number' => $data['serial_number'],
                        'brand' => $data['brand'],
                        'warrantyexpirationdate' => $data['warrantyexpirationdate'],
                        'fullbatterycapacity' => $data['fullbatterycapacity'],
                        'currentbatterycapacity' => $data['currentbatterycapacity'],
                        'diskperformance' => $data['diskperformance'],
                        'fullbatterycapacitydate' => $data['fullbatterycapacitydate'],
                        'currentbatterycapacitydate' => $data['currentbatterycapacitydate'],
                        'diskperformancedate' => $data['diskperformancedate'],
                        'spec' => $data['spec'],
                        'status' => $data['status'],
                        'picture' => $filename,
                    ]);
                }
    
                $response = [
                    'message' => 'Create Laptop Success',
                    'data' => $laptop
                ];
            } else {
                $response = [
                    'message' => 'Create Laptop fail'
                ];
            }

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $laptop = Laptop::find($id);

            $response = [
                'message' => 'Get Laptop Success',
                'data' => $laptop
            ];

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaptopRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $laptopCheck = Laptop::find($id);

            if ($laptopCheck) {
                if($request->has('picture')) {
                    foreach($request->file('picture') as $image) {
                        $filename = Str::random(32).".".$image->getClientOriginalExtension();
                        $image->move('uploads/', $filename);
        
                        $laptop = Laptop::find($id)->update([
                            'serial_number' => $data['serial_number'],
                            'brand' => $data['brand'],
                            'warrantyexpirationdate' => $data['warrantyexpirationdate'],
                            'fullbatterycapacity' => $data['fullbatterycapacity'],
                            'currentbatterycapacity' => $data['currentbatterycapacity'],
                            'diskperformance' => $data['diskperformance'],
                            'fullbatterycapacitydate' => $data['fullbatterycapacitydate'],
                            'currentbatterycapacitydate' => $data['currentbatterycapacitydate'],
                            'diskperformancedate' => $data['diskperformancedate'],
                            'spec' => $data['spec'],
                            'status' => $data['status'],
                            'picture' => $filename,
                        ]);
                    }
        
                    $response = [
                        'message' => 'Update Laptop Success',
                        'data' => $laptop
                    ];
                } else {
                    $response = [
                        'message' => 'Update Laptop fail'
                    ];
                }
            } else {
                $response = [
                    'message' => 'Update Laptop Fail, Id Not Found',
                ];
            }

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $laptop = Laptop::destroy($id);

            $response = [
                'message' => 'Delete Laptop Success',
                'data' => $laptop
            ];

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }
}

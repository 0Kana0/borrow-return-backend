<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowDevice\StoreBorrowDeviceArrayRequest;
use App\Http\Requests\BorrowDevice\UpdateBorrowDeviceArrayRequest;
use App\Http\Requests\BorrowDevice\UpdateBorrowDeviceRequest;
use App\Models\BorrowDevice;
use Illuminate\Http\Request;

class BorrowDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    public function storeArray(StoreBorrowDeviceArrayRequest $request)
    {
        try {
            $borrowDevice_success = array();
            foreach ($request->validated() as $data) {
                $borrowDevice = BorrowDevice::create([
                    'device_name' => $data['device_name'],
                    'serial_number' => $data['serial_number'],
                    'return_status' => $data['return_status'],
                    'borrow_id' => $data['borrow_id']
                ]);

                array_push($borrowDevice_success, $borrowDevice);
            }

            $response = [
                'message' => 'Create BorrowDeviceArray Success',
                'data' => $borrowDevice_success
            ];

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
    }

    public function showByBorrowId(string $borrow_id)
    {
        try {
            $borrowDevice = BorrowDevice::where('borrow_id', $borrow_id)->get();

            $response = [
                'message' => 'Get BorrowDevice From Borrow_id Success',
                'length' => count($borrowDevice),
                'data' => $borrowDevice
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
    public function update(UpdateBorrowDeviceRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $borrowDeviceCheck = BorrowDevice::find($id);

            if ($borrowDeviceCheck) {
                if ($data['return_status'] == true) {
                    $borrowDevice = BorrowDevice::find($id)->update([
                        'device_name' => $data['device_name'],
                        'serial_number' => $data['serial_number'],
                        'return_status' => $data['return_status'],
                        'return_date' => $data['return_date'],
                    ]);
                } else {
                    $borrowDevice = BorrowDevice::find($id)->update([
                        'device_name' => $data['device_name'],
                        'serial_number' => $data['serial_number'],
                        'return_status' => $data['return_status'],
                    ]);
                }

                $response = [
                    'message' => 'Update BorrowDevice Success',
                    'data' => $borrowDevice
                ];
            } else {
                $response = [
                    'message' => 'Update BorrowDevice Fail, Id Not Found',
                ];
            }

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }

    public function updateArray(UpdateBorrowDeviceArrayRequest $request)
    {
        try {
            $borrowDevice_success = array();
            foreach ($request->validated() as $data) {
                if ($data['return_status'] == true) {
                    $borrowDevice = BorrowDevice::find($data['id'])->update([
                        'device_name' => $data['device_name'],
                        'serial_number' => $data['serial_number'],
                        'return_status' => $data['return_status'],
                        'return_date' => $data['return_date'],
                    ]);
                } else {
                    $borrowDevice = BorrowDevice::find($data['id'])->update([
                        'device_name' => $data['device_name'],
                        'serial_number' => $data['serial_number'],
                        'return_status' => $data['return_status'],
                    ]);
                }

                array_push($borrowDevice_success, $borrowDevice);
            }

            $response = [
                'message' => 'Update BorrowDeviceArray Success',
                'data' => $borrowDevice_success
            ];

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
    }
}

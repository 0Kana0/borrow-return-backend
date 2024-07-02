<?php

namespace App\Http\Controllers;

use App\Http\Requests\Borrow\StoreBorrowRequest;
use App\Http\Requests\Borrow\UpdateBorrowRequest;
use App\Models\Borrow;
use App\Models\BorrowDevice;
use App\Models\Laptop;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $borrow = Borrow::join('branches', 'borrows.branch_id', '=', 'branches.id')
                            ->select('borrows.*', 'branches.branch_name')
                            ->get();

            $borrow->transform(function($item, $key) {
                $borrowDevice = BorrowDevice::where('borrow_id', $item['id'])
                            ->where(function ($query) {
                                $query->where('device_name', 'Laptop')
                                      ->orWhere('device_name', 'เปลี่ยน Laptop');
                            })
                            ->latest('created_at')
                            ->first();

                $laptop = Laptop::where('serial_number', $borrowDevice['serial_number'])->first();;

                $item->laptop_id = $laptop["id"];
                return $item;
            });

            $response = [
                'message' => 'Get All Borrow Success',
                'data' => $borrow
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
    public function store(StoreBorrowRequest $request)
    {
        try {
            $data = $request->validated();
            $borrow = Borrow::create([
                'borrow_number_id' => 'Test',
                'date' => $data['date'],
                'employee_id' => $data['employee_id'],
                'employee_name' => $data['employee_name'],
                'employee_phone' => $data['employee_phone'],
                'employee_rank' => $data['employee_rank'],
                'employee_dept' => $data['employee_dept'],
                'branch_id' => $data['branch_id']
            ]);
            
            $response = [
                'message' => 'Create Borrow Success',
                'data' => $borrow
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
        try {
            $borrow = Borrow::join('branches', 'borrows.branch_id', '=', 'branches.id')
                            ->select('borrows.*', 'branches.branch_name')
                            ->where('borrows.id', $id)
                            ->first();

            $borrowDevice = BorrowDevice::where('borrow_id', $id)
                                        ->where(function ($query) {
                                            $query->where('device_name', 'Laptop')
                                        ->orWhere('device_name', 'เปลี่ยน Laptop');
                                        })
                                        ->latest('created_at')
                                        ->first();

            $laptop = Laptop::where('serial_number', $borrowDevice['serial_number'])->first();;
            
            $borrow->laptop_id = $laptop['id'];

            $response = [
                'message' => 'Get Borrow Success',
                'data' => $borrow
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
    public function update(UpdateBorrowRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $borrowCheck = Borrow::find($id);

            if ($borrowCheck) {
                $borrow = Borrow::find($id)->update([
                    'employee_id' => $data['employee_id'],
                    'employee_name' => $data['employee_name'],
                    'employee_phone' => $data['employee_phone'],
                    'employee_rank' => $data['employee_rank'],
                    'employee_dept' => $data['employee_dept'],
                    'branch_id' => $data['branch_id']
                ]);
    
                $response = [
                    'message' => 'Update Borrow Success',
                    'data' => $borrow
                ];
            } else {
                $response = [
                    'message' => 'Update Borrow Fail, Id Not Found',
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
            $borrowDevice = BorrowDevice::where('borrow_id', $id)->delete();
            $borrow = Borrow::destroy($id);

            $response = [
                'message' => 'Delete Borrow Success',
                'data' => $borrow
            ];

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }
}

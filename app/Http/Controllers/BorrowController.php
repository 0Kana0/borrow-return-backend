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
            $borrow = Borrow::get();

            // ส่วนของการเพิ่มข้อมูล laptop_id ลงไปใน borrow เเต่ละ object
            $borrow->transform(function($item, $key) {
                // เรียกข้อมูล borrow_device ของ borrow ที่เกียวกับการยืม laptop อันล่าสุด
                $borrowDevice = BorrowDevice::where('borrow_id', $item['id'])
                                            ->where(function ($query) {
                                                $query->where('device_name', 'Laptop')
                                                    ->orWhere('device_name', 'เปลี่ยน Laptop');
                                            })
                                            ->latest('created_at')
                                            ->first();

                // ถ้าพบข้อมูลการยืม                            
                if ($borrowDevice) {
                    if ($borrowDevice['serial_number'] !== null) {
                        $laptop = Laptop::where('serial_number', $borrowDevice['serial_number'])->first();

                        // เพิ่ม laptop_id เข้าไปใน borrow
                        $item->laptop_id = $laptop["id"];
                        return $item;
                    } else {
                        // เพิ่ม laptop_id ที่เป็น null เข้าไปใน borrow
                        $item->laptop_id = null;
                        return $item;
                    }  
                // ถ้าไม่พบข้อมูลการยืม                   
                } else {
                    // เพิ่ม laptop_id ที่เป็น null เข้าไปใน borrow
                    $item->laptop_id = null;
                    return $item;
                }
            });

            $response = [
                'message' => 'Get All Borrow Success',
                'length' => count($borrow),
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
            
            // หาว่าวันที่ลงข้อมูลมีข้อมูล borrow อยู่เท่าไร
            $findlengthborrow = Borrow::where('date', $data['date'])->get();

            if (count($findlengthborrow) == 0) {
                // เเปลงวันที่ลงข้อมูลจาก yyyy-mm-dd เป็น yyyymmdd 
                $formattedDate = date("Ymd", strtotime($data['date']));
                $borrow_number_id = 'KDR'.$formattedDate.'0001';

                $borrow = Borrow::create([
                    'borrow_number_id' => $borrow_number_id,
                    'date' => $data['date'],
                    'employee_id' => $data['employee_id'],
                    'employee_name' => $data['employee_name'],
                    'employee_phone' => $data['employee_phone'],
                    'employee_rank' => $data['employee_rank'],
                    'employee_dept' => $data['employee_dept'],
                    'branch_name' => $data['branch_name']
                ]);
            } else {
                // หาข้อมูล borrow ล่าสุดของวันที่ลงข้อมูล
                $findlatestborrow = Borrow::where('date', $data['date'])
                                          ->latest('created_at')
                                          ->first();
                // นำ borrow_number_id มาตัด string เพื่อดูลำดับล่าสุด                         
                $numberlatestborrow = substr($findlatestborrow['borrow_number_id'], -4);
                // แปลงลำดับล่าสุดเป็น int
                $intnumberlatestborrow = intval($numberlatestborrow);
                $number = $intnumberlatestborrow + 1;
                // แปลงลำดับข้อมูลปัจจุบันเป็น string ในรูปแบบ 0000
                $formattedNumber = sprintf('%04d', $number);
                // เเปลงวันที่ลงข้อมูลจาก yyyy-mm-dd เป็น yyyymmdd 
                $formattedDate = date("Ymd", strtotime($data['date']));
                $borrow_number_id = 'KDR'.$formattedDate.$formattedNumber;

                $borrow = Borrow::create([
                    'borrow_number_id' => $borrow_number_id,
                    'date' => $data['date'],
                    'employee_id' => $data['employee_id'],
                    'employee_name' => $data['employee_name'],
                    'employee_phone' => $data['employee_phone'],
                    'employee_rank' => $data['employee_rank'],
                    'employee_dept' => $data['employee_dept'],
                    'branch_name' => $data['branch_name']
                ]);
            }
            
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
            $borrow = Borrow::where('borrows.id', $id)->first();

            // เรียกข้อมูล borrow_device ของ borrow ที่เกียวกับการยืม laptop อันล่าสุด
            $borrowDevice = BorrowDevice::where('borrow_id', $id)
                                        ->where(function ($query) {
                                            $query->where('device_name', 'Laptop')
                                        ->orWhere('device_name', 'เปลี่ยน Laptop');
                                        })
                                        ->latest('created_at')
                                        ->first();

            // ถ้าพบข้อมูลการยืม     
            if ($borrowDevice) {
                if ($borrowDevice['serial_number'] !== null) {
                    // เรียกข้อมูล laptop ตาม serial_number ใน borrow_device
                    $laptop = Laptop::where('serial_number', $borrowDevice['serial_number'])->first();;
            
                    // เพิ่ม laptop_id เข้าไปใน borrow
                    $borrow->laptop_id = $laptop['id'];
                } else {
                    // เพิ่ม laptop_id ที่เป็น null เข้าไปใน borrow
                    $borrow->laptop_id = null;
                }
            // ถ้าไม่พบข้อมูลการยืม 
            } else {
                // เพิ่ม laptop_id ที่เป็น null เข้าไปใน borrow
                $borrow->laptop_id = null;
            }
            
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
                    'branch_name' => $data['branch_name']
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
            // ลบ borrow_device ที่เกี่ยวกับ borrow นี้ทั้งหมด
            BorrowDevice::where('borrow_id', $id)->delete();
            // หาข้อมูลของ borrow ที่กำลังจะลบเพื่อเอา date มาใช้งาน
            $finddeleteborrow = Borrow::where('borrows.id', $id)->first();
            // ลบ borrow ตาม id
            $deleteborrow = Borrow::destroy($id);
            // ข้อมูลที่เหลือที่ต้องการรันค่า borrow_number_id ใหม่
            $dateborrow = Borrow::where('date', $finddeleteborrow['date'])->get();

            $index = 1;
            foreach ($dateborrow as $item) {
                // แปลงลำดับข้อมูลปัจจุบันเป็น string ในรูปแบบ 0000
                $formattedNumber = sprintf('%04d', $index);
                // เเปลงวันที่ลงข้อมูลจาก yyyy-mm-dd เป็น yyyymmdd 
                $formattedDate = date("Ymd", strtotime($item['date']));

                $borrow_number_id = 'KDR'.$formattedDate.$formattedNumber;

                Borrow::find($item['id'])->update([
                    'borrow_number_id' => $borrow_number_id,
                ]);

                $index += 1;
            }

            $response = [
                'message' => 'Delete Borrow Success',
                'data' => $deleteborrow
            ];

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }
}

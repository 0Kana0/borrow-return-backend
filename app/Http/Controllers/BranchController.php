<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $branch = Branch::get();

            $response = [
                'message' => 'Get All Branch Success',
                'length' => count($branch),
                'data' => $branch
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
    public function store(StoreBranchRequest $request)
    {
        try {
            $data = $request->validated();
            $branch = Branch::create([
                'branch_name' => $data['branch_name']
            ]);

            $response = [
                'message' => 'Create Branch Success',
                'data' => $branch
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
            $branch = Branch::find($id);

            $response = [
                'message' => 'Get Branch Success',
                'data' => $branch
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
    public function update(UpdateBranchRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $branchCheck = Branch::find($id);

            if ($branchCheck) {
                $branch = Branch::find($id)->update([
                    'branch_name' => $data['branch_name']
                ]);
    
                $response = [
                    'message' => 'Update Branch Success',
                    'data' => $branch
                ];
            } else {
                $response = [
                    'message' => 'Update Branch Fail, Id Not Found',
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
            $branch = Branch::destroy($id);

            $response = [
                'message' => 'Delete Branch Success',
                'data' => $branch
            ];

            return response($response);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th);
        }
    }
}

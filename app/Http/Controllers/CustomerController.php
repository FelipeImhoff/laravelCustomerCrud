<?php

namespace App\Http\Controllers;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string',
            'photo' => 'nullable|string'
        ]);
        
        $customer = new Customer();

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        if($request->photo != ''){
            $image = $request->photo;
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time().'.'.$ex;
            $img = Image::read($request->photo)->resize(200, 200);
            $upload_path = public_path() . '/upload/';
            $img->save($upload_path . $name);
            $customer->photo = $name;
        } else {
            $customer->photo = 'no-image.png';
        }
        $customer->save();
    }

    public function index() {
        $customers = Customer::query();
        $customers = $customers->latest()->paginate(5, ['*']);

        return response()->json([
            'customers' => $customers
        ], 200);

    }

    public function show($id) {
        $customer = Customer::find($id);
        return response()->json([
            'customer' => $customer
        ], 200);
    }

    public function update(Request $request, $id) {
        $customer = Customer::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string',
            'photo' => 'nullable|string'
        ]);

        if($request->photo != $customer->photo){
            $image = $request->photo;
            $strpos = strpos($image, ';');
            $sub = substr($image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . '.' . $ex;

            $img = Image::read($image)->resize(200, 200);
            $upload_path = public_path('upload/');

            if ($customer->photo
                && file_exists($upload_path . $customer->photo)
                && $customer->photo != 'no-image.png'
            ) {
                @unlink($upload_path . $customer->photo);
            }

            $img->save($upload_path . $name);
            $data['photo'] = $name;
        }

        $customer->update($data);

        return response()->json(['message' => 'Cliente atualizado com sucesso!']);
    }

    public function destroy($id) {
        $customer = Customer::findOrFail($id);

        @unlink($upload_path . $customer->photo);
        
        $customer->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso!']);
    }
}

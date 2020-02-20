<?php

namespace App\Http\Controllers\seller;

use Illuminate\Http\Request;
use App\category;
use App\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class products extends Controller
{
    public function insert(Request $request)
    {

        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'headings' => 'required',
            'detail_description' => 'required|max:255',
            'price' => 'required|numeric|max:2000000',
            'size' => 'required|max:50',
            'time' => 'required|max:50',
            'level' => 'required|max:20',
            'category' => 'required',
            'image1' => 'required|image|mimes:jpg,png,jpeg|max:10240',
            'image2' => 'required|file',

        ]);


        $categoryId = category::find($request->category);

        if ($categoryId != null) {

            $ProductImage = $request->file('image1');
            $AttachFileProduct = $request->file('image2');

            $ProductImage->move('ProductImage', $ProductImage->getClientOriginalName());
            $AttachFileProduct->move('AttachFileProduct', $AttachFileProduct->getClientOriginalName());

            $newProduct = new product();

            $newProduct->title = $request->title;
            $newProduct->description = $request->description;
            $newProduct->headings = $request->headings;
            $newProduct->detail_description = $request->detail_description;
            $newProduct->price = $request->price;
            $newProduct->size = $request->size;
            $newProduct->time = $request->time;
            $newProduct->level = $request->level;
            $newProduct->categoryId = $request->category;
            $newProduct->ProductImage = $ProductImage->getClientOriginalName();
            $newProduct->AttachFileProduct = $AttachFileProduct->getClientOriginalName();
            $newProduct->path_image = url('/') . '/ProductImage/' . $ProductImage->getClientOriginalName();
            $newProduct->userId = Auth::user()->id;

            $newProduct->save();

            return redirect('seller/addProduct')->with('sucuss', $newProduct->id);

        } else {
            return redirect('seller/addProduct')->with('sucuss', 0);
        }

    }

    public function delete($id)
    {
        $Product = product::find($id);

        $Product->delete();

        $check = product::find($id);

        if ($check == null) {
            return redirect('seller/editProduct')->with('deleteStatus', 'true');
        } else {
            return redirect('seller/editProduct')->with('deleteStatus', 'false');
        }
    }

    public function edit(Request $request)
    {

        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'headings' => 'required',
            'detail_description' => 'required|max:255',
            'price' => 'required|numeric|max:2000000',
            'size' => 'required|max:50',
            'time' => 'required|max:50',
            'level' => 'required|max:20',
            'category' => 'required',
            'image1' => 'image|mimes:jpg,png,jpeg',
            'image2' => 'file',
        ]);

        $Product = product::find($request->id);

        if ($request->hasFile('image1')) {

            File::delete('ProductImage/' . $Product->ProductImage);

            $ProductImage = $request->file('image1');
            $ProductImage->move('ProductImage', $ProductImage->getClientOriginalName());
            $Product->ProductImage = $ProductImage->getClientOriginalName();
            $Product->path_image = url('/') . '/ProductImage/' . $ProductImage->getClientOriginalName();
        }

        if ($request->hasFile('image2')) {

            File::delete('AttachFileProduct/' . $Product->AttachFileProduct);

            $AttachFileProduct = $request->file('image2');
            $AttachFileProduct->move('AttachFileProduct', $AttachFileProduct->getClientOriginalName());
            $Product->AttachFileProduct = $AttachFileProduct->getClientOriginalName();
        }

        $Product->title = $request->title;
        $Product->price = $request->price;
        $Product->size = $request->size;
        $Product->time = $request->time;
        $Product->description = $request->description;
        $Product->level = $request->level;
        $Product->detail_description = $request->detail_description;
        $Product->headings = $request->headings;
        $Product->categoryId = $request->category;
        $Product->userId = Auth::user()->id;

        $Product->save();

        return redirect('seller/editProduct-sub' . $request->id)->with('updateStatus', 'true');


    }

    public function Search(Request $request)
    {
        $request->validate([
            'search_product' => 'required'
        ]);

        if ($request->search_with != null) {
            if ($request->search_with == 'title' || $request->search_with == 'price') {
                $SearchProduct = product::where($request->search_with, 'like', '%' . $request->search_product . '%')
                    ->where('userId', Auth::user()->id)->get();
            } else {
                return redirect('seller/editProduct')->with('error', 'دوباره تلاش کنید!');
            }
        } else {
            $SearchProduct = product::where('title', 'like', '%' . $request->search_product . '%')
                ->where('userId', Auth::user()->id)->get();
        }

        return view('seller.editProduct', compact('SearchProduct'));
    }


}

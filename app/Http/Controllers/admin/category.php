<?php

namespace App\Http\Controllers\admin;

use App\product;
use Illuminate\Http\Request;

class category extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|max:30',
            'subCategory' => 'required|max:10'
        ]);


        $findCategory = \App\category::where('categoryName', $request->categoryName)->get();

        $confirm = '';
        foreach ($findCategory as $temp) {
            $confirm = $temp;
        }

        if (!isset($confirm->id)) {

            $insertCategory = new \App\category();

            $insertCategory->categoryName = $request->categoryName;
            $insertCategory->sid = $request->subCategory;

            $insertCategory->save();

            if (isset($insertCategory->id)) {
                return redirect('admin/addcategory')->with('insertSuccess', 'true');
            } else {
                return redirect('admin/addcategory')->with('insertSuccess', 'false');
            }
        } else {
            return redirect('admin/addcategory')->with('categoryExist', 'دسته مورد نظر وجود دارد!');
        }


    }

    public function delete($id)
    {
        $category = \App\category::find($id);

        $category->delete();

        $ProductDelete = product::where('categoryId', $id)->delete();

        $subCategoryForDeleteProduct = \App\category::where('sid', $id)->get();

        foreach ($subCategoryForDeleteProduct as $temp) {
            $ProductList = product::where('categoryId', $temp->id)->delete();
        }

        $subCategory = \App\category::where('sid', $id)->delete();

        $check = \App\category::find($id);

        if ($check == null) {
            return redirect('admin/editcategory')->with('deleteStatus', 'true');
        } else {
            return redirect('admin/editcategory')->with('deleteStatus', 'false');
        }
    }


    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'categoryName' => 'required|max:30',
            'subCategory' => 'required|max:10'
        ]);

        $category = \App\category::find($request->id);
        $category->categoryName = $request->categoryName;
        $category->sid = $request->subCategory;

        $category->save();

        return redirect('admin/editCategory-sub' . $request->id)->with('EditStatus', 'true');
    }

    public function Search(Request $request)
    {
        $request->validate([
            'search_category' => 'required'
        ]);

        if ($request->search_with != null) {
            if ($request->search_with == 'categoryName') {
                $SearchCategory = \App\category::where($request->search_with, 'like', '%' . $request->search_category . '%')->get();
            } else {
                return redirect('admin/editCategory')->with('error', 'دوباره تلاش کنید!');
            }
        } else {
            $SearchCategory = \App\category::where('categoryName', 'like', '%' . $request->search_category . '%')->get();
        }

        return view('admin.editCategory', compact('SearchCategory'));
    }
}

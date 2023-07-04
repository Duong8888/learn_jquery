<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('products.list', compact('products'));
    }

    public function indexAjax()
    {
        $products = Product::orderBy('id', 'desc')->get();
        $template = '';
        foreach ($products as $key => $product) {
            $template .= '<tr>
                <td>
                    <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                        <input type="checkbox" class="form-check-input" id="' . $product->id . '" name="' . $product->id . '">
                        <label class="form-check-label" for="' . $product->id . '"></label>
                    </div>
                </td>
                <td>' . $product->name . '</td>
                <td>' . $product->description . '</td>
                <td>
                    <span class="badge light ' . ($product->status == 0 ? "badge-danger" : ($product->status == 1 ? "badge-warning" : "badge-success")) . '">' . ($product->status == '0' ? "Canceled" : ($product->status == '1' ? "Pending" : "Successful")) . '</span>
                </td>
                <td>$' . number_format($product->price) . '</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-success light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                </g>
                            </svg>
                        </button>
                        <div class="dropdown-menu" style="">
                            <button type="button" class="dropdown-item  btn-update" id="' . $product->id . '">Edit</button>
                            <button type="button" class="dropdown-item btn-delete" id="' . $product->id . '">Delete</button>
                        </div>
                    </div>
                </td>
            </tr>';

        }
        return $template;
    }

    public function addProduct(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('product.index');
    }

    public function deleteProduct(Request $request, $id = null)
    {
        if ($request->has('arrayID')) {
            $responsAjax = $request->arrayID;
            parse_str($responsAjax, $arrayProductDelete);
            foreach ($arrayProductDelete as $key => $value) {
                Product::destroy($key);
            }
        } else {
            Product::destroy($id);
        }
        return redirect()->route('product.index');
    }

    public function updateProduct($id, Request $request)
    {
        $product = Product::find($id);
        if ($request->has('id')) {
            $product = Product::find($request->id);
            $product->update($request->all());
        }
        return $product;
    }
}

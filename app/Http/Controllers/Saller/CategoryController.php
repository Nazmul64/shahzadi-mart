<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::latest()->get();
        return view('saller.pages.category.index', compact('categories'));
    }

    public function subCategories()
    {
        $subCategories = SubCategory::with('category')->latest()->get();
        return view('saller.pages.category.subcategory', compact('subCategories'));
    }

    public function childCategories()
    {
        $childCategories = ChildSubCategory::with('subcategory.category')->latest()->get();
        return view('saller.pages.category.childcategory', compact('childCategories'));
    }
}

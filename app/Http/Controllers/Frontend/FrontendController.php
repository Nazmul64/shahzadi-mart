<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\Generalsetting;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // ─── Reusable Sidebar Query ──────────────────────────────────────────────
    private function getSidebarCategories()
    {
        return Category::where('status', 'active')
            ->with([
                'subCategories' => function ($q) {
                    $q->where('status', 'active')
                      ->with([
                          'childCategories' => function ($q2) {
                              $q2->where('status', 'active');
                          }
                      ]);
                }
            ])
            ->get();
    }

    // ─── Homepage ─────────────────────────────────────────────────────────────
    public function frontend()
    {
        $websetting        = Generalsetting::first();
        $slider            = Slider::all();
        $categories        = Category::where('status', 'active')->get();
        $sidebarCategories = $this->getSidebarCategories();

        $flashProducts = Product::where('status', 'active')
                            ->where('is_flash_sale', true)
                            ->latest()
                            ->take(8)
                            ->get();

        $hotCategories = Category::where('status', 'active')
                            ->where('featured', 'active')
                            ->get();

        $newArrivals = Product::where('status', 'active')
                            ->where('is_new_arrival', true)
                            ->latest('arrived_at')
                            ->take(8)
                            ->get();

        $bestSellers = Product::where('status', 'active')
                            ->whereNotNull('discount_price')
                            ->where('discount_price', '>', 0)
                            ->orderByRaw('(current_price - discount_price) DESC')
                            ->take(8)
                            ->get();

        return view('frontend.index', compact(
            'slider', 'categories', 'websetting',
            'flashProducts', 'hotCategories',
            'newArrivals', 'bestSellers', 'sidebarCategories'
        ));
    }

    // ─── Category Page ────────────────────────────────────────────────────────
    public function categoryPage($slug)
    {
        $category = Category::where('slug', $slug)
                        ->where('status', 'active')
                        ->with([
                            'subCategories' => function ($q) {
                                $q->where('status', 'active')
                                  ->with([
                                      'childCategories' => function ($q2) {
                                          $q2->where('status', 'active');
                                      }
                                  ]);
                            }
                        ])
                        ->firstOrFail();

        $subIds   = $category->subCategories->pluck('id');
        $childIds = $category->subCategories
                        ->flatMap(fn($s) => $s->childCategories->pluck('id'));

        $products = Product::where('status', 'active')
                        ->where(function ($q) use ($category, $subIds, $childIds) {
                            $q->where('category_id', $category->id)
                              ->orWhereIn('sub_category_id', $subIds)
                              ->orWhereIn('child_sub_category_id', $childIds);
                        })
                        ->latest()
                        ->paginate(20);

        $sidebarCategories = $this->getSidebarCategories();
        $websetting        = Generalsetting::first();

        return view('frontend.category', compact(
            'category', 'products', 'sidebarCategories', 'websetting'
        ));
    }

    // ─── SubCategory Page ─────────────────────────────────────────────────────
    public function subCategoryPage($catSlug, $subSlug)
    {
        $category = Category::where('slug', $catSlug)
                        ->where('status', 'active')
                        ->firstOrFail();

        $subCategory = SubCategory::where('slug', $subSlug)
                            ->where('category_id', $category->id)
                            ->where('status', 'active')
                            ->with([
                                'childCategories' => fn($q) => $q->where('status', 'active')
                            ])
                            ->firstOrFail();

        $childIds = $subCategory->childCategories->pluck('id');

        $products = Product::where('status', 'active')
                        ->where(function ($q) use ($subCategory, $childIds) {
                            $q->where('sub_category_id', $subCategory->id)
                              ->orWhereIn('child_sub_category_id', $childIds);
                        })
                        ->latest()
                        ->paginate(20);

        $sidebarCategories = $this->getSidebarCategories();
        $websetting        = Generalsetting::first();

        return view('frontend.subcategory', compact(
            'category', 'subCategory', 'products', 'sidebarCategories', 'websetting'
        ));
    }

    // ─── Child Category Page ──────────────────────────────────────────────────
    public function childCategoryPage($catSlug, $subSlug, $childSlug)
    {
        $category = Category::where('slug', $catSlug)
                        ->where('status', 'active')
                        ->firstOrFail();

        $subCategory = SubCategory::where('slug', $subSlug)
                            ->where('category_id', $category->id)
                            ->where('status', 'active')
                            ->firstOrFail();

        $childCategory = ChildSubCategory::where('slug', $childSlug)
                            ->where('sub_category_id', $subCategory->id)
                            ->where('status', 'active')
                            ->firstOrFail();

        $products = Product::where('status', 'active')
                        ->where('child_sub_category_id', $childCategory->id)
                        ->latest()
                        ->paginate(20);

        $siblingChildren = ChildSubCategory::where('sub_category_id', $subCategory->id)
                                ->where('status', 'active')
                                ->get();

        $sidebarCategories = $this->getSidebarCategories();
        $websetting        = Generalsetting::first();

        return view('frontend.childcategory', compact(
            'category', 'subCategory', 'childCategory',
            'products', 'siblingChildren', 'sidebarCategories', 'websetting'
        ));
    }

    // ─── Product Details ──────────────────────────────────────────────────────
    public function productdetails($slug)
    {
        $product = Product::with(['category', 'subCategory'])
            ->where('slug', $slug)
            ->orWhere('id', is_numeric($slug) ? $slug : 0)
            ->firstOrFail();

        $relatedProducts = Product::with(['category'])
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                if ($product->category_id) {
                    $q->where('category_id', $product->category_id);
                }
            })
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        // ✅ এই দুইটা আগে missing ছিল — এখন add করা হয়েছে
        $sidebarCategories = $this->getSidebarCategories();
        $websetting        = Generalsetting::first();

        return view('frontend.productdetails.productdetails', compact(
            'product', 'relatedProducts', 'sidebarCategories', 'websetting'
        ));
    }

    // ─── User Dashboard ───────────────────────────────────────────────────────
    public function user_dashboard()
    {
        return view('userdashboard.master');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\Contact;
use App\Models\Generalsetting;
use App\Models\Product;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Slider;
use App\Models\Websitefavicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $websitefavicon = Websitefavicon::first();

        $slider            = Slider::all();
        $categories        = Category::where('status', 'active')->get();
        $sidebarCategories = $this->getSidebarCategories();

        $flashProducts = Product::where('status', 'active')
                            ->where('is_flash_sale', true)
                            ->latest()
                            ->take(20)
                            ->get();

        $hotCategories = Category::where('status', 'active')
                            ->where('featured', 'active')
                            ->get();

        $newArrivals = Product::where('status', 'active')
                            ->where('is_new_arrival', true)
                            ->latest('arrived_at')
                            ->take(20)
                            ->get();

        $bestSellers = Product::where('status', 'active')
                            ->whereNotNull('discount_price')
                            ->where('discount_price', '>', 0)
                            ->orderByRaw('(current_price - discount_price) DESC')
                            ->take(20)
                            ->get();

        return view('frontend.index', compact(
            'slider', 'categories', 'websetting',
            'flashProducts', 'hotCategories',
            'newArrivals', 'bestSellers', 'sidebarCategories',
            'websitefavicon',
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
    $userId = Auth::id();

    // শুধুমাত্র লগইন করা ইউজারের অর্ডার
    $orders = Order::where('user_id', $userId)
                   ->with('items.product')
                   ->latest()
                   ->get();

    // Wishlist — শুধু এই ইউজারের
    $wishlistItems = Wishlist::where('user_id', $userId)
                             ->with('product.category')
                             ->latest()
                             ->get();

    // Stats
    $totalOrders    = $orders->count();
    $pendingOrders  = $orders->where('order_status', 'pending')->count();
    $deliveredOrders= $orders->where('order_status', 'delivered')->count();
    $cancelledOrders= $orders->where('order_status', 'cancelled')->count();
    $wishlistCount  = $wishlistItems->count();

    return view('userdashboard.index', compact(
        'orders',
        'wishlistItems',
        'totalOrders',
        'pendingOrders',
        'deliveredOrders',
        'cancelledOrders',
        'wishlistCount'
    ));
}

// ─── Cancel Order (শুধু নিজের অর্ডার) ────────────────────────────────────────
public function cancelOrder($orderNumber)
{
    // Auth::id() দিয়ে নিশ্চিত করা হচ্ছে যে শুধু নিজের অর্ডারই cancel করতে পারবে
    $order = Order::where('order_number', $orderNumber)
                  ->where('user_id', Auth::id())
                  ->firstOrFail();

    // শুধু pending বা processing অর্ডার cancel করা যাবে
    if (! in_array($order->order_status, ['pending', 'processing'])) {
        return redirect()->back()->with('error', 'এই অর্ডারটি আর বাতিল করা সম্ভব নয়।');
    }

    $order->update(['order_status' => 'cancelled']);

    return redirect()->back()->with('success', 'অর্ডার #' . $order->order_number . ' সফলভাবে বাতিল হয়েছে।');
}


    public function allProducts(Request $request)
{
    $websetting        = Generalsetting::first();
    $categories        = Category::where('status', 'active')->get();
    $sidebarCategories = $this->getSidebarCategories();

    // ── Base Query ──
    $query = Product::where('status', 'active');

    // ── Filter: Category ──
    if ($request->filled('category')) {
        $cat = Category::where('slug', $request->category)->first();
        if ($cat) {
            $subIds   = $cat->subCategories()->pluck('id');
            $childIds = \App\Models\ChildSubCategory::whereIn('sub_category_id', $subIds)->pluck('id');

            $query->where(function ($q) use ($cat, $subIds, $childIds) {
                $q->where('category_id', $cat->id)
                  ->orWhereIn('sub_category_id', $subIds)
                  ->orWhereIn('child_sub_category_id', $childIds);
            });
        }
    }

    // ── Filter: Search ──
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // ── Filter: Price Range ──
    if ($request->filled('min_price')) {
        $query->where(function ($q) use ($request) {
            $q->whereRaw('COALESCE(discount_price, current_price) >= ?', [$request->min_price]);
        });
    }
    if ($request->filled('max_price')) {
        $query->where(function ($q) use ($request) {
            $q->whereRaw('COALESCE(discount_price, current_price) <= ?', [$request->max_price]);
        });
    }

    // ── Filter: In Stock ──
    if ($request->filled('in_stock')) {
        $query->where(function ($q) {
            $q->where('is_unlimited', true)
              ->orWhere('stock', '>', 0);
        });
    }

    // ── Sort ──
    switch ($request->get('sort', 'latest')) {
        case 'price_low':
            $query->orderByRaw('COALESCE(discount_price, current_price) ASC');
            break;
        case 'price_high':
            $query->orderByRaw('COALESCE(discount_price, current_price) DESC');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'discount':
            $query->whereNotNull('discount_price')
                  ->where('discount_price', '>', 0)
                  ->orderByRaw('(current_price - discount_price) DESC');
            break;
        default: // 'latest'
            $query->latest();
            break;
    }

    $products = $query->paginate(20)->withQueryString();

    return view('frontend.allproducts', compact(
        'products', 'categories', 'websetting', 'sidebarCategories'
    ));
}
// ─── Shop Page ────────────────────────────────────────────────────────────────
public function shop(Request $request)
{
    $websetting        = Generalsetting::first();
    $categories        = Category::where('status', 'active')->get();
    $sidebarCategories = $this->getSidebarCategories();

    $query = Product::where('status', 'active');

    // Filter: Category
    if ($request->filled('category')) {
        $cat = Category::where('slug', $request->category)->first();
        if ($cat) {
            $subIds   = $cat->subCategories()->pluck('id');
            $childIds = \App\Models\ChildSubCategory::whereIn('sub_category_id', $subIds)->pluck('id');
            $query->where(function ($q) use ($cat, $subIds, $childIds) {
                $q->where('category_id', $cat->id)
                  ->orWhereIn('sub_category_id', $subIds)
                  ->orWhereIn('child_sub_category_id', $childIds);
            });
        }
    }

    // Sort
    switch ($request->get('sort', 'latest')) {
        case 'price_low':
            $query->orderByRaw('COALESCE(discount_price, current_price) ASC');
            break;
        case 'price_high':
            $query->orderByRaw('COALESCE(discount_price, current_price) DESC');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'discount':
            $query->whereNotNull('discount_price')
                  ->where('discount_price', '>', 0)
                  ->orderByRaw('(current_price - discount_price) DESC');
            break;
        default:
            $query->latest();
            break;
    }

    $products = $query->paginate(20)->withQueryString();

    return view('frontend.shop', compact(
        'products', 'categories', 'websetting', 'sidebarCategories'
    ));
}

// ─── Offers Page ──────────────────────────────────────────────────────────────
public function offers(Request $request)
{
    $websetting        = Generalsetting::first();
    $sidebarCategories = $this->getSidebarCategories();

    // Flash sale products
    $flashProducts = Product::where('status', 'active')
                        ->where('is_flash_sale', true)
                        ->latest()
                        ->take(8)
                        ->get();

    // Discount products (paginated)
    $query = Product::where('status', 'active')
                    ->whereNotNull('discount_price')
                    ->where('discount_price', '>', 0);

    // Sort
    if ($request->get('sort') === 'discount') {
        $query->orderByRaw('(current_price - discount_price) DESC');
    } else {
        $query->orderByRaw('(current_price - discount_price) DESC');
    }

    $discountProducts = $query->paginate(16)->withQueryString();

    return view('frontend.offers', compact(
        'flashProducts', 'discountProducts', 'websetting', 'sidebarCategories'
    ));
}

// ─── New Arrivals Page ────────────────────────────────────────────────────────
public function newArrivals(Request $request)
{
    $websetting        = Generalsetting::first();
    $sidebarCategories = $this->getSidebarCategories();

    $query = Product::where('status', 'active')
                    ->where('is_new_arrival', true);

    // Filter: when
    if ($request->get('when') === 'week') {
        $query->where('arrived_at', '>=', now()->subWeek());
    } elseif ($request->get('when') === 'month') {
        $query->where('arrived_at', '>=', now()->subMonth());
    }

    $newArrivals = $query->latest('arrived_at')->paginate(20)->withQueryString();

    return view('frontend.new-arrivals', compact(
        'newArrivals', 'websetting', 'sidebarCategories'
    ));

}
   public function contactDetails()
    {
        $contact =Contact::latest()->first();
        $websetting = Generalsetting::first();
        return view('frontend.contactdetails.index', compact('contact', 'websetting'));
    }
}

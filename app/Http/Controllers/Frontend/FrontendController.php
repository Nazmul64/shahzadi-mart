<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaigncreate;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\Contact;
use App\Models\Generalsetting;
use App\Models\Product;
use App\Models\Order;
use App\Models\Pixel;
use App\Models\Producreview;
use App\Models\Wishlist;
use App\Models\Slider;
use App\Models\Tagmanager;
use App\Models\Page;

use App\Models\Contactinfomationadmin;
use App\Models\AboutForCompany;
use App\Models\Footercategory;
use App\Models\Websitefavicon;
use App\Models\Tremsandcondation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class FrontendController extends Controller
{
    // ─── Constructor — tracking vars সব view-এ share করা হচ্ছে ──────────────
    public function __construct()
    {
        /*
         * $Pixelid ও $GoogleAnalytics header/footer-এ দরকার।
         * প্রতিটা method-এ আলাদা করে compact() এ দেওয়ার বদলে
         * View::share() দিয়ে globally share করা হচ্ছে।
         * এতে কোনো page থেকেই tracking miss হবে না।
         */
        $Pixelid         = Pixel::first();
        $GoogleAnalytics = Tagmanager::first();

        View::share('Pixelid',         $Pixelid);
        View::share('GoogleAnalytics', $GoogleAnalytics);
    }

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
        $websitefavicon    = Websitefavicon::first();
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
        $contactinformationadmin=Contactinfomationadmin::latest()->first();
        $pagecrate = Footercategory::with(['pages' => function($q) {$q->where('status', 1);}])->get();

        return view('frontend.index', compact(
            'slider', 'categories', 'websetting',
            'flashProducts', 'hotCategories',
            'newArrivals', 'bestSellers', 'sidebarCategories',
            'websitefavicon','contactinformationadmin','pagecrate'
            // $Pixelid ও $GoogleAnalytics constructor থেকে shared হচ্ছে
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

        $orders = Order::where('user_id', $userId)
                       ->with('items.product')
                       ->latest()
                       ->get();

        $wishlistItems = Wishlist::where('user_id', $userId)
                                 ->with('product.category')
                                 ->latest()
                                 ->get();

        $totalOrders     = $orders->count();
        $pendingOrders   = $orders->where('order_status', 'pending')->count();
        $deliveredOrders = $orders->where('order_status', 'delivered')->count();
        $cancelledOrders = $orders->where('order_status', 'cancelled')->count();
        $wishlistCount   = $wishlistItems->count();

        $reviewableStatuses = ['processing', 'shipped', 'in_transit', 'delivered'];
        $reviewableOrders   = $orders->whereIn('order_status', $reviewableStatuses);

        $myReviewMap = Producreview::where('user_id', $userId)
                        ->get()
                        ->keyBy('product_id');

        $pendingReviewCount = 0;
        foreach ($reviewableOrders as $_ord) {
            foreach ($_ord->items as $_item) {
                if ($_item->product_id && !isset($myReviewMap[$_item->product_id])) {
                    $pendingReviewCount++;
                }
            }
        }

        return view('userdashboard.index', compact(
            'orders',
            'wishlistItems',
            'totalOrders',
            'pendingOrders',
            'deliveredOrders',
            'cancelledOrders',
            'wishlistCount',
            'reviewableOrders',
            'myReviewMap',
            'pendingReviewCount'
        ));
    }

    // ─── Order History ────────────────────────────────────────────────────────
    public function orderHistory(Request $request)
    {
        $userId = Auth::id();

        $query = Order::where('user_id', $userId)->with('items.product');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $allOrders        = Order::where('user_id', $userId)->get();
        $totalOrders      = $allOrders->count();
        $pendingOrders    = $allOrders->where('order_status', 'pending')->count();
        $processingOrders = $allOrders->where('order_status', 'processing')->count();
        $shippedOrders    = $allOrders->where('order_status', 'shipped')->count();
        $deliveredOrders  = $allOrders->where('order_status', 'delivered')->count();
        $cancelledOrders  = $allOrders->where('order_status', 'cancelled')->count();

        $totalSpent = $allOrders
            ->whereIn('order_status', ['delivered', 'processing', 'shipped', 'in_transit'])
            ->sum('total');

        $websetting = Generalsetting::first();

        return view('userdashboard.order-history', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalSpent',
            'websetting'
        ));
    }

    // ─── Cancel Order ─────────────────────────────────────────────────────────
    public function cancelOrder($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'এই অর্ডারটি আর বাতিল করা সম্ভব নয়।');
        }

        $order->update(['order_status' => 'cancelled']);

        return redirect()->back()->with('success', 'অর্ডার #' . $order->order_number . ' সফলভাবে বাতিল হয়েছে।');
    }

    // ─── All Products ─────────────────────────────────────────────────────────
    public function allProducts(Request $request)
    {
        $websetting        = Generalsetting::first();
        $categories        = Category::where('status', 'active')->get();
        $sidebarCategories = $this->getSidebarCategories();

        $query = Product::where('status', 'active');

        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->first();
            if ($cat) {
                $subIds   = $cat->subCategories()->pluck('id');
                $childIds = ChildSubCategory::whereIn('sub_category_id', $subIds)->pluck('id');
                $query->where(function ($q) use ($cat, $subIds, $childIds) {
                    $q->where('category_id', $cat->id)
                      ->orWhereIn('sub_category_id', $subIds)
                      ->orWhereIn('child_sub_category_id', $childIds);
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->whereRaw('COALESCE(discount_price, current_price) >= ?', [$request->min_price]);
        }
        if ($request->filled('max_price')) {
            $query->whereRaw('COALESCE(discount_price, current_price) <= ?', [$request->max_price]);
        }
        if ($request->filled('in_stock')) {
            $query->where(function ($q) {
                $q->where('is_unlimited', true)->orWhere('stock', '>', 0);
            });
        }

        switch ($request->get('sort', 'latest')) {
            case 'price_low':  $query->orderByRaw('COALESCE(discount_price, current_price) ASC');  break;
            case 'price_high': $query->orderByRaw('COALESCE(discount_price, current_price) DESC'); break;
            case 'name_asc':   $query->orderBy('name', 'asc'); break;
            case 'discount':
                $query->whereNotNull('discount_price')->where('discount_price', '>', 0)
                      ->orderByRaw('(current_price - discount_price) DESC');
                break;
            default: $query->latest(); break;
        }

        $products = $query->paginate(20)->withQueryString();

        return view('frontend.allproducts', compact(
            'products', 'categories', 'websetting', 'sidebarCategories'
        ));
    }

    // ─── Shop Page ────────────────────────────────────────────────────────────
    public function shop(Request $request)
    {
        $websetting        = Generalsetting::first();
        $categories        = Category::where('status', 'active')->get();
        $sidebarCategories = $this->getSidebarCategories();

        $query = Product::where('status', 'active');

        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->first();
            if ($cat) {
                $subIds   = $cat->subCategories()->pluck('id');
                $childIds = ChildSubCategory::whereIn('sub_category_id', $subIds)->pluck('id');
                $query->where(function ($q) use ($cat, $subIds, $childIds) {
                    $q->where('category_id', $cat->id)
                      ->orWhereIn('sub_category_id', $subIds)
                      ->orWhereIn('child_sub_category_id', $childIds);
                });
            }
        }

        switch ($request->get('sort', 'latest')) {
            case 'price_low':  $query->orderByRaw('COALESCE(discount_price, current_price) ASC');  break;
            case 'price_high': $query->orderByRaw('COALESCE(discount_price, current_price) DESC'); break;
            case 'name_asc':   $query->orderBy('name', 'asc'); break;
            case 'discount':
                $query->whereNotNull('discount_price')->where('discount_price', '>', 0)
                      ->orderByRaw('(current_price - discount_price) DESC');
                break;
            default: $query->latest(); break;
        }

        $products = $query->paginate(20)->withQueryString();

        return view('frontend.shop', compact(
            'products', 'categories', 'websetting', 'sidebarCategories'
        ));
    }

    // ─── Offers Page ──────────────────────────────────────────────────────────
    public function offers(Request $request)
    {
        $websetting        = Generalsetting::first();
        $sidebarCategories = $this->getSidebarCategories();

        $flashProducts = Product::where('status', 'active')
                            ->where('is_flash_sale', true)
                            ->latest()
                            ->take(8)
                            ->get();

        $discountProducts = Product::where('status', 'active')
                            ->whereNotNull('discount_price')
                            ->where('discount_price', '>', 0)
                            ->orderByRaw('(current_price - discount_price) DESC')
                            ->paginate(16)
                            ->withQueryString();

        return view('frontend.offers', compact(
            'flashProducts', 'discountProducts', 'websetting', 'sidebarCategories'
        ));
    }

    // ─── New Arrivals Page ────────────────────────────────────────────────────
    public function newArrivals(Request $request)
    {
        $websetting        = Generalsetting::first();
        $sidebarCategories = $this->getSidebarCategories();

        $query = Product::where('status', 'active')->where('is_new_arrival', true);

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

    // ─── Contact ──────────────────────────────────────────────────────────────
    public function contactDetails()
    {
        $contact    = Contact::latest()->first();
        $websetting = Generalsetting::first();
        return view('frontend.contactdetails.index', compact('contact', 'websetting'));
    }

    // ─── Campaign ─────────────────────────────────────────────────────────────
    public function campaignManage($id)
    {
        $websetting        = Generalsetting::first();
        $sidebarCategories = $this->getSidebarCategories();
        $campaign          = Campaigncreate::with('product')->findOrFail($id);

        return view('frontend.campaignmanage', compact(
            'websetting', 'sidebarCategories', 'campaign'
        ));
    }

    // ─── About Company ───────────────────────────────────────────────────────
    public function aboutcompany()
    {
        $websetting = Generalsetting::first();
        $aboutcompany = AboutForCompany::latest()->first();
        return view('frontend.aboutcompany', compact('websetting', 'aboutcompany'));
     }
      public function termsAndConditions()
    {
        $websetting = Generalsetting::first();
        $termsAndConditions = Tremsandcondation::latest()->first();
        return view('frontend.terms-and-conditions', compact('websetting', 'termsAndConditions'));
     }




public function multiplepage($id)
{
    $page = Page::where('id', $id)->where('status', 1)->firstOrFail();

    // frontend master layout এ যা যা লাগে
    $websetting       = Generalsetting::first();
    $websitefavicon   = Websitefavicon::first();
    $contactinformationadmin = Contactinfomationadmin::latest()->first();
    $pagecrate        = Footercategory::with(['pages' => function($q) {
                            $q->where('status', 1);
                        }])->get();

    return view('frontend.multiplepage', compact(
        'page', 'websetting', 'websitefavicon',
        'contactinformationadmin', 'pagecrate'
    ));
}
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSetting;
use Illuminate\Http\Request;

class ProductSettingController extends Controller
{
    public function index()
    {
        $settings = ProductSetting::instance();
        return view('admin.productsetting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_whole_sale_max_quantity' => 'required|integer|min:1',
            'display_flash_deal_products'     => 'required|integer|min:1',
            'display_hot_products'            => 'required|integer|min:1',
            'display_new_products'            => 'required|integer|min:1',
            'display_sale_products'           => 'required|integer|min:1',
            'display_best_seller_products'    => 'required|integer|min:1',
            'display_popular_products'        => 'required|integer|min:1',
            'display_top_rated_products'      => 'required|integer|min:1',
            'display_big_save_products'       => 'required|integer|min:1',
            'display_trending_products'       => 'required|integer|min:1',
            'category_products_per_page'      => 'required|integer|min:1',
            'vendor_products_per_page'        => 'required|integer|min:1',
            'display_products_by_seller'      => 'required|integer|min:1',
            'wishlist_products_per_page'      => 'required|integer|min:1',
            'view_wishlist_product_per_page'  => 'required|string',
            'catalog_min_price'               => 'required|numeric|min:0',
            'catalog_max_price'               => 'required|numeric|min:0',
            'catalog_view_product_per_page'   => 'required|integer|min:1',
        ]);

        $settings = ProductSetting::instance();

        $settings->update([
            'display_stock_number'            => $request->has('display_stock_number'),
            'product_whole_sale_max_quantity' => $request->product_whole_sale_max_quantity,

            'display_flash_deal_products'     => $request->display_flash_deal_products,
            'display_hot_products'            => $request->display_hot_products,
            'display_new_products'            => $request->display_new_products,
            'display_sale_products'           => $request->display_sale_products,
            'display_best_seller_products'    => $request->display_best_seller_products,
            'display_popular_products'        => $request->display_popular_products,
            'display_top_rated_products'      => $request->display_top_rated_products,
            'display_big_save_products'       => $request->display_big_save_products,
            'display_trending_products'       => $request->display_trending_products,

            'category_products_per_page'      => $request->category_products_per_page,
            'vendor_products_per_page'        => $request->vendor_products_per_page,

            'display_contact_seller'          => $request->has('display_contact_seller'),
            'display_products_by_seller'      => $request->display_products_by_seller,

            'vendor_physical_products'        => $request->has('vendor_physical_products'),
            'vendor_digital_products'         => $request->has('vendor_digital_products'),
            'vendor_license_products'         => $request->has('vendor_license_products'),
            'vendor_listing_products'         => $request->has('vendor_listing_products'),
            'vendor_affiliate_products'       => $request->has('vendor_affiliate_products'),

            'wishlist_products_per_page'      => $request->wishlist_products_per_page,
            'view_wishlist_product_per_page'  => $request->view_wishlist_product_per_page,

            'catalog_min_price'               => $request->catalog_min_price,
            'catalog_max_price'               => $request->catalog_max_price,
            'catalog_view_product_per_page'   => $request->catalog_view_product_per_page,
        ]);

        return redirect()->back()->with('success', 'Product settings saved successfully.');
    }
}

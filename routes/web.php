<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function () {
    /*Start Login and Register Routes*/

    /* Start ClientArea Auth */

    // Authentication Routes...
    Route::get('login', 'ClientArea\LoginController@show')->name('login');
    Route::post('login', 'ClientArea\LoginController@login');
    Route::post('user/logout', 'ClientArea\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'ClientArea\RegisterController@show');
    Route::post('register', 'ClientArea\RegisterController@Register');


    /* End ClientArea Auth */

    Route::get('moreProduct{id}', function ($id) {
        return view('client.moreProducts', compact('id'));
    });

    //Auth::routes();
    /*End Login and Register Routes*/


    Route::get('/', function () {
        return view('index');
    });

    Route::get('aboutUs', function () {
        return view('aboutUs');
    });

    Route::post('InfoEmailList', 'admin\infoEmail@insert');

    Route::get('admin/addAboutUs', function () {
        return view('admin.addAboutUs');
    });
    Route::post('admin/addAboutUs', 'general@index');

    Route::get('Categories{category}', function ($category) {
        return view('client.Categories', compact('category'));
    });

    /* Start product Routes */
    Route::get('productDetail{id}', function ($id) {
        return view('client.ProductDetail', compact('id'));
    });
    /* End product Routes */

    /*Start Cart Route*/

    Route::get('cart', function () {
        return view('client.cart');
    });

    Route::post('cart/add/coupon', 'ClientArea\cart@coupon');
    Route::get('cart/delete/coupon', 'ClientArea\cart@deleteCoupon');

    Route::post('cart/delete/product/{id}', 'ClientArea\cart@deleteCart');

    Route::get('LoginOrRegister', function () {
        return view('auth.CartLoginRegist');
    });

    /*End Cart Route*/

    /* Start checkout and purchase Route */
    Route::get('checkout', function () {
        return view('client.checkout');
    });

    Route::post('checkout', 'Clientarea\cart@RegisterOrder');

    Route::get('purchase', function () {
        return view('client.purchase');
    });

    Route::post('purchase', 'ClientArea\order@insert');

    /* End checkout Route */

    /* Start support Routes */
    Route::get('supportWays', function () {
        return view('client.supportways');
    });
    /*End Support Routes*/

    /* Start Search page Routes */

    Route::get('{value}', function ($value) {
        return view('client.search', compact('value'));
    });

    /* End Search page Routes */

    /* start Reset Password */

    Route::post('password/reset', 'Email\PasswordReset\ForgotPassword@SendLink'); //send reset link to email

    Route::get('password/reset/{token}/{id}', 'Email\PasswordReset\ResetPassword@ResetEmail'); //reset email and send new password

    /* End Reset Password */


    /* Start Admin Routes */

    Route::group(['prefix' => 'admin/'], function () {

        Route::get('login', 'admin\LoginController@show');
        Route::post('login', 'admin\LoginController@login');
        Route::get('logout', 'admin\LoginController@logout');

        Route::get('profile', function () {
            return view('admin.profile');
        });

        Route::post('profile', 'admin\user@EditProfile');

        Route::get('main', function () {
            return view('admin.admin');
        });

        Route::get('addProduct', function () {
            return view('admin.addProduct');
        });

        Route::post('addProduct', 'admin\products@insert');

        Route::get('deleteProduct{id}', 'admin\products@delete');

        Route::get('editProduct', function () {
            return view('admin.editProduct');
        });

        Route::post('searchProduct', 'admin\products@Search');

        Route::get('editProduct-sub{id}', function ($id) {
            return view('admin.editProduct-sub', compact('id'));
        });

        Route::post('editProduct-sub', 'admin\products@edit');

        Route::get('addcategory', function () {
            return view('admin.addCategory');
        });

        Route::post('addCategory', 'admin\category@insert');

        Route::post('searchCategory', 'admin\category@Search');

        Route::get('deleteCategory{id}', 'admin\category@delete');

        Route::get('editcategory', function () {
            return view('admin.editCategory');
        });

        Route::get('editCategory-sub{id}', function ($id) {
            return view('admin/editCategory-sub', compact('id'));
        });

        Route::post('editCategory-sub', 'admin\category@edit');

        Route::get('addCoupon', function () {
            return view('admin.addCoupon');
        });

        Route::post('addCoupon', 'admin\coupon@insert');

        Route::get('editCoupon', function () {
            return view('admin.editCoupon');
        });

        Route::get('editCoupon-sub{id}', function ($id) {
            return view('admin.editCoupon-sub', compact('id'));
        });

        Route::post('editCoupon-sub', 'admin\coupon@Edit');

        Route::get('deleteCoupon{id}', 'admin\coupon@Delete');

        Route::post('searchCoupon', 'admin\coupon@Search');


        Route::get('orders', function () {
            return view('admin.orders');
        });

        Route::post('orderDetail', 'admin\order@orderDetail');

        Route::post('searchOrder', 'admin\order@search');

        Route::get('customers', function () {
            return view('admin.customers');
        });

        Route::post('searchUser', 'admin\user@Search');

        Route::get('sellerRequest', function () {
            return view('admin.sellerRequest');
        });

        Route::post('searchSeller', 'admin\user@SearchSeller');

        Route::get('ConfirmSellerRequest{id}', 'admin\user@ConfirmSellerRequest');

        Route::get('sellerList', function () {
            return view('admin.sellerList');
        });

        Route::post('searchSellerList', 'admin\user@SearchSellerList');

        Route::get('DenySeller{id}', 'admin\user@DenySeller');

        Route::get('infoEmailList', function () {
            return view('admin.infoEmailList');
        });

        Route::post('searchUserEmail', 'admin\infoEmail@search');

        Route::get('deleteUserEmail{id}', 'admin\infoEmail@delete');

        Route::get('sendInfoEmail', function () {
            return view('admin.sendInfoEmail');
        });

        Route::post('SendEmailNews', 'admin\infoEmail@SendEmail');


        Route::get('productChart', function () {
            return view('admin.productChart');
        });

        Route::get('comments', function () {
            return view('admin.comments');
        });

        Route::get('deleteComment{id}', 'admin\comment@delete');
        Route::get('searchComment', 'admin\comment@search');
        Route::get('showComment{id}', 'admin\comment@Show');

    });


    Route::group(['prefix' => 'seller/'], function () {

        Route::get('login', 'seller\LoginController@show');
        Route::post('login', 'seller\LoginController@login');
        Route::get('logout', 'seller\LoginController@logout');

        Route::get('profile', function () {
            return view('seller.profile');
        });

        Route::post('profile', 'seller\user@EditProfile');

        Route::get('main', function () {
            return view('seller.admin');
        });

        Route::get('addProduct', function () {
            return view('seller.addProduct');
        });

        Route::post('addProduct', 'seller\products@insert');

        Route::get('deleteProduct{id}', 'seller\products@delete');

        Route::get('editProduct', function () {
            return view('seller.editProduct');
        });

        Route::post('searchProduct', 'seller\products@Search');

        Route::get('editProduct-sub{id}', function ($id) {
            return view('seller.editProduct-sub', compact('id'));
        });

        Route::post('editProduct-sub', 'seller\products@edit');

        Route::get('orders', function () {
            return view('seller.orders');
        });

        Route::post('orderDetail', 'seller\order@orderDetail');

        Route::post('searchOrder', 'seller\order@search');

        Route::get('productChart', function () {
            return view('seller.productChart');
        });

        Route::get('comments', function () {
            return view('seller.comments');
        });

        Route::get('deleteComment{id}', 'seller\comment@delete');
        Route::get('searchComment', 'seller\comment@search');
        Route::get('showComment{id}', 'seller\comment@Show');

    });


    Route::group(['prefix' => 'user/'], function () {
        Route::get('main', function () {
            return view('client.home');
        });

        Route::get('profile', function () {
            return view('client.profile');
        });

        Route::post('profile', 'ClientArea\user@EditProfile');

        Route::get('showOrders', function () {
            return view('client.orders');
        });

        Route::post('showOrders', 'ClientArea\order@showOrders');
    });


    Route::post('addComment', 'ClientArea\comment@insert');

    /* End Admin Routes */

});


/* Start confirmation Account */
Route::get('email/confirmation/{ConfirmationCode}/{id}', 'Email\AccountConfirm\ActiveEmail@index');
/* End confirmation Account */

/* Start Phone Routes */
Route::get('Api/loginApi/{username}/{password}', 'Api@LoginApi');
Route::get('Api/registerApi/{name}/{username}/{password}', 'Api@RegisterApi');
Route::get('Api/categoryApi', 'Api@ShowCategory');
Route::get('Api/productApi', 'Api@ShowProduct');
Route::get('Api/bankApi', 'Api@ShowBank');
Route::get('Api/aboutUsApi', 'Api@ShowAboutUs');
Route::get('Api/cheaperApi', 'Api@Cheaper');
Route::get('Api/expensiveApi', 'Api@Expensive');
Route::get('Api/mostOrderApi', 'Api@MostOrder');
Route::get('Api/productInCategoryApi/{name}', 'Api@ShowProductInCategory');
Route::get('Api/searchApi/{title}', 'Api@Search');
Route::get('Api/productDetailApi/{id}', 'Api@showProductDetail');
Route::get('Api/checkCouponApi/{couponCode}/{productId}', 'Api@CheckCoupon');
Route::get('Api/changePasswordApi/{id}/{lastPassword}/{newPassword}/{reNewPassword}', 'Api@ChangePassword');
Route::get('Api/editUserdApi/{id}/{email}/{name}/{family}/{phone}', 'Api@EditUser');
Route::get('Api/showOrdersApi/{id}', 'Api@ShowOrders');
Route::get('Api/showDownloadLink/{id}', 'Api@ShowDownloadLink');
Route::get('Api/buyOrder/{userId}/{ProductId}', 'Api@buyOrder');
Route::get('Api/addOrder/{userId}/{ProductId}/{BankId}', 'Api@AddOrder');
/* End Phone Routes */


<?php

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::resource('', 'OrderController')->parameters(['' => 'order']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'OrderController@deletes',
                'permission' => 'orders.destroy',
            ]);
            Route::post('charge', [
                'as'         => 'charge',
                'uses'       => 'OrderController@charge',
                'permission' => 'orders.create',
            ]);

            Route::get('quick-search', [
                'as'         => 'quick-search',
                'uses'       => 'OrderController@quicksearch',
                'permission' => 'orders.index',
            ]);
            Route::post('capture', [
                'as'         => 'capture',
                'uses'       => 'OrderController@capture',
                'permission' => 'orders.create',
            ]);
            Route::get('import', [
                'as'         => 'import',
                'uses'       => 'OrderController@import',
                'permission' => 'order-import.index',
            ]);
            Route::post('import-order', [
                'as'         => 'import-order',
                'uses'       => 'OrderController@importOrder',
                'permission' => 'order-import.index',
            ]);

            Route::get('edit-order/{id}', [
                'as'         => 'editOrder',
                'uses'       => 'OrderController@editOrder',
                'permission' => 'orders.edit',
            ]);

            Route::get('order/reciept/{orders}', [
                'as'         => 'printReceipt',
                'uses'       => 'OrderController@printReceipt',
                'permission' => 'orders.edit',
            ]);

            Route::get('reorder', [
                'as'         => 'reorder',
                'uses'       => 'OrderController@getReorder',
                'permission' => 'orders.create',
            ]);

            Route::get('generate-invoice/{id}', [
                'as'         => 'generate-invoice',
                'uses'       => 'OrderController@getGenerateInvoice',
                'permission' => 'orders.edit',
            ]);

            Route::post('confirm', [
                'as'         => 'confirm',
                'uses'       => 'OrderController@postConfirm',
                'permission' => 'orders.edit',
            ]);

            Route::post('send-order-confirmation-email/{id}', [
                'as'         => 'send-order-confirmation-email',
                'uses'       => 'OrderController@postResendOrderConfirmationEmail',
                'permission' => 'orders.edit',
            ]);

            Route::post('create-shipment/{id}', [
                'as'         => 'create-shipment',
                'uses'       => 'OrderController@postCreateShipment',
                'permission' => 'orders.edit',
            ]);

            Route::post('cancel-shipment/{id}', [
                'as'         => 'cancel-shipment',
                'uses'       => 'OrderController@postCancelShipment',
                'permission' => 'orders.edit',
            ]);

            Route::post('update-shipping-address/{id}', [
                'as'         => 'update-shipping-address',
                'uses'       => 'OrderController@postUpdateShippingAddress',
                'permission' => 'orders.edit',
            ]);

            Route::post('cancel-order/{id}', [
                'as'         => 'cancel',
                'uses'       => 'OrderController@postCancelOrder',
                'permission' => 'orders.edit',
            ]);

            Route::get('print-shipping-order/{id}', [
                'as'         => 'print-shipping-order',
                'uses'       => 'OrderController@getPrintShippingOrder',
                'permission' => 'orders.edit',
            ]);

            Route::post('confirm-payment/{id}', [
                'as'         => 'confirm-payment',
                'uses'       => 'OrderController@postConfirmPayment',
                'permission' => 'orders.edit',
            ]);

            Route::get('get-shipment-form/{id}', [
                'as'         => 'get-shipment-form',
                'uses'       => 'OrderController@getShipmentForm',
                'permission' => 'orders.edit',
            ]);

            Route::post('refund/{id}', [
                'as'         => 'refund',
                'uses'       => 'OrderController@postRefund',
                'permission' => 'orders.edit',
            ]);

            Route::get('get-available-shipping-methods', [
                'as'         => 'get-available-shipping-methods',
                'uses'       => 'OrderController@getAvailableShippingMethods',
                'permission' => 'orders.edit',
            ]);

            Route::post('coupon/apply', [
                'as'         => 'apply-coupon-when-creating-order',
                'uses'       => 'OrderController@postApplyCoupon',
                'permission' => 'orders.create',
            ]);

            Route::post('change-status', [
                'as'         => 'changeStatus',
                'uses'       => 'OrderController@changeStatus',
                'permission' => 'orders.create',
            ]);

            Route::get('verify-product-shipment/{orderId}/{prodId}/{prodQty}', [
                'as'         => 'verifyOrderProductShipment',
                'uses'       => 'OrderController@verifyOrderProductShipment',
                'permission' => 'orders.create',
            ]);

            Route::get('verify-product-shipment-barcode/{orderId}/{barcode}', [
                'as'         => 'verifyOrderProductShipmentBarcode',
                'uses'       => 'OrderController@verifyOrderProductShipmentBarcode',
                'permission' => 'orders.create',
            ]);

            Route::post('save-advance-search/{type}', [
                'as'         => 'save.advance.search',
                'uses'       => 'OrderController@saveAdvanceSearch',
                'permission' => 'orders.create',
            ]);

            Route::get('revert-order-refund-product/{order_id}/{prod_id}', [
                'as'         => 'order.revert.refund.product',
                'uses'       => 'OrderController@orderRevertRefundProduct',
                'permission' => 'orders.create',
            ]);
            Route::post('order-refund-product/{id}', [
                'as'         => 'order.refund.product',
                'uses'       => 'OrderController@orderRefundProduct',
                'permission' => 'orders.create',
            ]);
            Route::post('split-order/{id}', [
                'as'         => 'split.order',
                'uses'       => 'OrderController@splitOrder',
                'permission' => 'orders.create',
            ]);
            Route::post('split-payment/{id}', [
                'as'         => 'split.payment',
                'uses'       => 'OrderController@splitPayment',
                'permission' => 'orders.create',
            ]);
            Route::post('sales-rep/{id}', [
                'as'         => 'sales-rep',
                'uses'       => 'OrderController@salesRepupdate',
                'permission' => 'orders.create',
            ]);

            Route::get('remove-discount/{id}', [
                'as'         => 'remove-discount',
                'uses'       => 'OrderController@removeDiscount',
                'permission' => 'orders.create',
            ]);

            Route::get('order-invoice/{id}', [
                'as'         => 'orderInvoice',
                'uses'       => 'OrderController@createInvoice',
                'permission' => 'orders.create',
            ]);

            Route::get('push-order-to-old-system/{id}', [
                'as'         => 'pushOrderToOldSystem',
                'uses'       => 'OrderController@pushOrderToOldSystem',
                'permission' => 'orders.edit',
            ]);
            Route::get('fetch-old-system-order/{id}', [
                'as'         => 'fetchOldSystemOrder',
                'uses'       => 'OrderController@fetchOldSystemOrder',
                'permission' => 'orders.edit',
            ]);
            Route::get('fetch-old-system-card/{id}', [
                'as'         => 'fetchOldSystemCard',
                'uses'       => 'OrderController@fetchOldSystemCard',
                'permission' => 'orders.edit',
            ]);
            Route::get('send-invoice/{id}', [
                'as'         => 'sendInvoice',
                'uses'       => 'OrderController@sendInvoice',
                'permission' => 'orders.edit',
            ]);

        });

        Route::group(['prefix' => 'incomplete-orders', 'as' => 'orders.'], function () {
            Route::get('', [
                'as'         => 'incomplete-list',
                'uses'       => 'OrderController@getIncompleteList',
                'permission' => 'orders.index',
            ]);

            Route::get('view/{id}', [
                'as'         => 'view-incomplete-order',
                'uses'       => 'OrderController@getViewIncompleteOrder',
                'permission' => 'orders.index',
            ]);

            Route::post('send-order-recover-email/{id}', [
                'as'         => 'send-order-recover-email',
                'uses'       => 'OrderController@postSendOrderRecoverEmail',
                'permission' => 'orders.index',
            ]);
        });
    });
});

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers\Fronts', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::group(['prefix' => 'checkout/{token}', 'as' => 'public.checkout.'], function () {
            Route::get('/', [
                'as'   => 'information',
                'uses' => 'PublicCheckoutController@getCheckout',
            ]);

            Route::post('information', [
                'as'   => 'save-information',
                'uses' => 'PublicCheckoutController@postSaveInformation',
            ]);

            Route::post('process', [
                'as'   => 'process',
                'uses' => 'PublicCheckoutController@postCheckout',
            ]);

            Route::get('success', [
                'as'   => 'success',
                'uses' => 'PublicCheckoutController@getCheckoutSuccess',
            ]);

            Route::get('recover', [
                'as'   => 'recover',
                'uses' => 'PublicCheckoutController@getCheckoutRecover',
            ]);
        });
    });
});

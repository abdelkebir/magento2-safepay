define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'mage/url',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Customer/js/customer-data',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/checkout-data',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/checkout-data-resolver',
        'uiRegistry',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magento_Checkout/js/action/redirect-on-success',
        'Godogi_Safepay/js/safepaycheckout'
    ],
    function ($, Component, url, selectPaymentMethodAction, customerData, errorProcessor, fullScreenLoader, checkoutData, quote, checkoutDataResolver, registry, additionalValidators, redirectOnSuccessAction) {
        'use strict';


        return Component.extend({
            redirectAfterPlaceOrder: true, //This is important, so the customer isn't redirected to success.phtml by default
            defaults: {
                template: 'Godogi_Safepay/payment/safepaymod'
            },
            /**
             * Place order.
             */
            placeOrder: function (data, event) {
                var self = this;
                if (event) {
                    event.preventDefault();
                }
                self.isPlaceOrderActionAllowed(false);
                self.getPlaceOrderDeferredObject()
                    .fail(
                        function () {
                            self.isPlaceOrderActionAllowed(true);
                        }
                    ).done(
                        function () {
                            data['form_key'] = $.cookie('form_key');
                            var custom_controller_url = url.build('safepaymod/safepay/postdata');
                            $.ajax( custom_controller_url , // create checkout on ACH server
                            {
                                type: 'POST',
                                dataType: 'json',
                                showLoader: true,
                                data: data,
                                success: function (data, status, xhr) {
                                    $('#safepaymod-errors').hide(200);
                                    $('#safepaymod-errors').empty();
                                    if(data['success'] == true){
                                    }else{
                                        var errorHtml = '<p>'+ $.mage.__(data["message"]) +'</p>';
                                        $('#safepaymod-errors').append(errorHtml);
                                        $('#safepaymod-errors').show(200);
                                    }
                                },
                                error: function (jqXhr, textStatus, errorMessage) {
                                    return false;
                                }
                            });
                            self.afterPlaceOrder();
                            if (self.redirectAfterPlaceOrder) {
                                redirectOnSuccessAction.execute();
                            }

                        }
                    );
            },
            /**
             * After place order callback
             */
            afterPlaceOrder: function () {

            },
            /**
             * Initialize view.
             *
             * @return {exports}
             */
            initialize: function () {
                var self = this;
                var existCondition = setInterval(function() {
                    if ($('#safepaymod-container').length) {
                          clearInterval(existCondition);
                          var safepaySandboxKey = window.checkoutConfig.safepay_sandbox_key;
                          var safepayProductionKey = window.checkoutConfig.safepay_production_key;
                          var safepayTest = window.checkoutConfig.safepay_test;
                          var env = 'sandbox';
                          if(!safepayTest){
                              env = 'production';
                          }
                          safepay.Button.render({
                              env: env,
                              amount: quote.totals._latestValue.base_grand_total,
                              client: {
                                "sandbox": safepaySandboxKey,
                                "production": safepayProductionKey
                              },
                              payment: function (data, actions) {
                                return actions.payment.create({
                                  transaction: {
                                    amount: quote.totals._latestValue.base_grand_total,
                                    currency: quote.totals._latestValue.base_currency_code
                                  }
                                })
                              },
                              onCancel: function (data, actions) {
                                console.log("Something is not right !!!");
                              },
                              onCheckout: function(data, actions) {
                                  console.log("You completed the payment !!!");
                                  self.placeOrder(data);
                              }
                          }, '#safepaymod-container');
                      }
                }, 300);
                var billingAddressCode,
                    billingAddressData,
                    defaultAddressData;
                this._super().initChildren();
                quote.billingAddress.subscribe(function (address) {
                    this.isPlaceOrderActionAllowed(address !== null);
                }, this);
                checkoutDataResolver.resolveBillingAddress();
                billingAddressCode = 'billingAddress' + this.getCode();
                registry.async('checkoutProvider')(function (checkoutProvider) {
                    defaultAddressData = checkoutProvider.get(billingAddressCode);
                    if (defaultAddressData === undefined) {
                        // Skip if payment does not have a billing address form
                        return;
                    }
                    billingAddressData = checkoutData.getBillingAddressFromData();
                    if (billingAddressData) {
                        checkoutProvider.set(
                            billingAddressCode,
                            $.extend(true, {}, defaultAddressData, billingAddressData)
                        );
                    }
                    checkoutProvider.on(billingAddressCode, function (providerBillingAddressData) {
                        checkoutData.setBillingAddressFromData(providerBillingAddressData);
                    }, billingAddressCode);
                });
                return this;
            }
        });
    }
);

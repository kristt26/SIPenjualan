angular.module("app", ["ngRoute","Ctrl"])
.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "apps/Views/main.html",
        controller:"MainController"
    })
    .when("/City", {
        templateUrl : "apps/Views/City.html",
        controller:"CityController"
    })
    
    .when("/PanggilUser", {
        templateUrl : "apps/Views/User.html",
        controller:"UserController"
    })

    .when("/Customer", {
        templateUrl : "apps/Views/Customer.html",
        controller:"CustomerController"
    })
    .when("/InvDetail", {
        templateUrl : "apps/Views/InvDetail.html",
        controller:"InvoiceDetailController"
    })
    .when("/Invoice", {
        templateUrl : "apps/Views/Invoice.html",
        controller:"InvoicesController"
    })
    .when("/Penjualan", {
        templateUrl : "apps/Views/Penjualan.html",
        controller:"InvoicesController"
    })

    .when("/Prices", {
        templateUrl : "apps/Views/Prices.html",
        controller:"PricesController"
    })

    .when("/Collies", {
        templateUrl : "apps/Views/Collies.html",
        controller:"ColliesController"
    })
    ;
});
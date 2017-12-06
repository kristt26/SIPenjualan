angular.module("app", ["ngRoute", "Ctrl"])
    .config(function($routeProvider) {
        $routeProvider
            .when("/", {
                templateUrl: "apps/Views/main.html",
                controller: "MainController"
            })
            .when("/City", {
                templateUrl: "apps/Views/City.html",
                controller: "CityController"
            })

        .when("/PanggilUser", {
            templateUrl: "apps/Views/User.html",
            controller: "UserController"
        })

        .when("/Customer", {
                templateUrl: "apps/Views/Customer.html",
                controller: "CustomerController"
            })
            .when("/InvDetail", {
                templateUrl: "apps/Views/InvDetail.html",
                controller: "InvoiceDetailController"
            })
            .when("/Invoice", {
                templateUrl: "apps/Views/Invoice.html",
                controller: "InvoicesController"
            })
            .when("/Penjualan", {
                templateUrl: "apps/Views/Penjualan.html",
                controller: "PenjualanController"
            })

        .when("/Prices", {
            templateUrl: "apps/Views/Prices.html",
            controller: "PricesController"
        })

        .when("/Collies", {
            templateUrl: "apps/Views/Collies.html",
            controller: "ColliesController"
        })

        .when("/AddPenjualan", {
            templateUrl: "apps/Views/Create.html",
            controller: "PenjualanController"
        })

        .when("/form", {
            templateUrl: "apps/Views/form.html",
            controller: ""
        });
    })

.filter('daterange', function() {
    return function(conversations, start_date, end_date) {
        var result = [];

        // date filters
        var start_date = (start_date && !isNaN(Date.parse(start_date))) ? Date.parse(start_date) : 0;
        var end_date = (end_date && !isNaN(Date.parse(end_date))) ? Date.parse(end_date) : new Date();

        // if the conversations are loaded
        if (conversations && conversations.length > 0) {
            $.each(conversations, function(index, conversation) {
                var conversationDate = (conversation.CreateDate && !isNaN(Date.parse(conversation.CreateDate))) ? Date.parse(conversation.CreateDate) : 0;
                // var conversationDate = new Date(conversation.CreateDate);

                if (conversationDate >= start_date && conversationDate <= end_date) {
                    result.push(conversation);
                }
            });

            return result;
        }
    };
});
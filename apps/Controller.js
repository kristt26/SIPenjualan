angular.module("Ctrl", [])
    .controller("MainController", function ($scope) {

        $scope.Init = function () {
            $scope.Title = "Ini Judul Dari Controller";
        }
    })

    .controller("CityController", function ($scope, $http) {
        $scope.DataCity = [];
        $scope.DatasInputCity={};
        $scope.SelectedItemCity={};
        $scope.Init = function () {
            var GetCity = "api/City.php?action=GetCity";
            $http({
                method: "get",
                url: GetCity
            })
                .then(function (response) {
                    $scope.DataCity = response.data;
                }, function (error) {
                    alert(err.Massage);
                })


        }

        //Proses Insert Data City
        $scope.InsertDataCity=function(){
            var Data = $scope.DatasInputCity;
            var InsertCity = "api/City.php?action=InsertCity";

            $http({
                method: "post",
                url: InsertCity,
                data:Data
            })
            .then(function(response){
                if(response!=0)
                {
                    Data.Id = response.data;
                    $scope.DataCity.push(angular.copy(Data));
                }
                else
                    alert("Data Gagal disimpan");
            }, function(error){
                alert(err.Massage);
            })            
        }

        //Selected Item City
        $scope.Selected=function(item){
            $scope.SelectedItemCity=item;            
        }

        //Update Data City
        $scope.UpdateDataCity= function(){
            var UpdateCity = "api/City.php?action=UpdateCity";
            $http({
                method:"post",
                url:UpdateCity,
                data:$scope.SelectedItemCity
            })
            .then(function(response){
                if(response.data==1)
                {

                }
            }, function(error){
                alert(err.Massage);
            })
        }

        
    })

    .controller("UserController", function ($scope, $http) {
        $scope.DataUsers = [];
        $scope.DataSelected={};
        $scope.InputUser={};
        
        $scope.Init = function () {
            var UrlUser = "api/User.php?action=GetUser";
            $http({
                method:"get",
                url: UrlUser
            })
            .then(function(response){
                $scope.DataUsers=response.data;
            }, function(error){
                alert(err.Massage);
            })
        }
        $scope.SelectedUser=function(item){
            $scope.DataSelected=item;
        }

        //Funsi Insert User
        $scope.InsertDataUser = function(){
            var InsertUser= "api/User.php?action=InsertUser";
            var Datasimpan=$scope.InputUser;
            $http({
                method:"post",
                url:InsertUser,
                data:Datasimpan
            })
            .then(function(response){
                if(response.data!=0)
                {
                    Datasimpan.Id=response.data;
                    $scope.DataUsers.push(angular.copy(Datasimpan));
                    $scope.InputUser={};
                }
            }, function(error){
                alert(err.Massage);
            })
        }
    })

    .controller("CustomerController", function ($scope, $http) {
        $scope.DataCustomer=[];
        $scope.Init=function(){
            var UrlCustomer = "api/Customer.php?action=GetCustomer";
            $http({
                method: "get",
                url:UrlCustomer
            })
            .then(function(response){
                $scope.DataCustomer=response.data;
            }, function(error){
                alert(err.Massage);
            })
        }

    })

    .controller("InvoiceDetailController", function ($scope, $http) {
        $scope.DataInvDetail=[];
        $scope.Init=function(){
            var UrlInvDetailController = "api/InvDetail.php?action=GetInvDetail";
            $http({
                method: "get",
                url:UrlInvDetailController
            })
            .then(function(response){
                $scope.DataInvDetail=response.data;
            }, function(error){
                alert(err.Massage);
            })
        }
        
    })

    .controller("PenjualanController", function ($scope, $http) {
        $scope.DataPenjualan=[];
        $scope.Init=function(){
            var UrlPenjualan = "api/Penjualan.php?action=GetPenjualan";
            $http({
                method: "get",
                url:UrlPenjualan
            })
            .then(function(response){
                $scope.DataPenjualan=response.data;
            }, function(error){
                alert(err.Massage);
            })
        }

    })

    .controller("PricesController", function ($scope, $http) {
        $scope.DataPrices=[];
        $scope.Init=function(){
            var UrlPrices = "api/Prices.php?action=GetPrices";
            $http({
                method: "get",
                url:UrlPrices
            })
            .then(function(response){
                $scope.DataPrices=response.data;
            }, function(error){
                alert(err.Massage);
            })
        }

    })
    
    .controller("InvoicesController", function ($scope, $http) {
        
    })

    .controller("PenjualanController", function ($scope, $http) {
        
    })

    .controller("CollesController", function ($scope, $http) {
        
    })
    ;
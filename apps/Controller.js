angular.module("Ctrl", [])


.controller("MainController", function($scope) {

    $scope.Init = function() {
        $scope.Title = "Ini Judul Dari Controller";
    }
})

.controller("CityController", function($scope, $http) {
    $scope.DataCity = [];
    $scope.DatasInputCity = {};
    $scope.SelectedItemCity = {};
    $scope.Init = function() {
        var GetCity = "api/City.php?action=GetCity";
        $http({
                method: "get",
                url: GetCity
            })
            .then(function(response) {
                $scope.DataCity = response.data;
            }, function(error) {
                alert(err.Massage);
            })


    }

    //Proses Insert Data City
    $scope.InsertDataCity = function() {
        var Data = $scope.DatasInputCity;
        var InsertCity = "api/City.php?action=InsertCity";

        $http({
                method: "post",
                url: InsertCity,
                data: Data
            })
            .then(function(response) {
                if (response != 0) {
                    Data.Id = response.data;
                    $scope.DataCity.push(angular.copy(Data));
                } else
                    alert("Data Gagal disimpan");
            }, function(error) {
                alert(err.Massage);
            })
    }

    //Selected Item City
    $scope.Selected = function(item) {
        $scope.SelectedItemCity = item;
    }

    //Update Data City
    $scope.UpdateDataCity = function() {
        var UpdateCity = "api/City.php?action=UpdateCity";
        $http({
                method: "post",
                url: UpdateCity,
                data: $scope.SelectedItemCity
            })
            .then(function(response) {
                if (response.data == 1) {

                }
            }, function(error) {
                alert(err.Massage);
            })
    }


})

.controller("UserController", function($scope, $http) {
    $scope.DataUsers = [];
    $scope.DataSelected = {};
    $scope.InputUser = {};

    $scope.Init = function() {
        var UrlUser = "api/User.php?action=GetUser";
        $http({
                method: "get",
                url: UrlUser
            })
            .then(function(response) {
                $scope.DataUsers = response.data;
            }, function(error) {
                alert(err.Massage);
            })
    }
    $scope.SelectedUser = function(item) {
        $scope.DataSelected = item;
    }

    //Funsi Insert User
    $scope.InsertDataUser = function() {
        var InsertUser = "api/User.php?action=InsertUser";
        var Datasimpan = $scope.InputUser;
        $http({
                method: "post",
                url: InsertUser,
                data: Datasimpan
            })
            .then(function(response) {
                if (response.data != 0) {
                    Datasimpan.Id = response.data;
                    $scope.DataUsers.push(angular.copy(Datasimpan));
                    $scope.InputUser = {};
                }
            }, function(error) {
                alert(err.Massage);
            })
    }
})

.controller("CustomerController", function($scope, $http) {
    $scope.DataCustomer = [];
    $scope.Init = function() {
        var UrlCustomer = "api/Customer.php?action=GetCustomer";
        $http({
                method: "get",
                url: UrlCustomer
            })
            .then(function(response) {
                $scope.DataCustomer = response.data;
            }, function(error) {
                alert(err.Massage);
            })
    }

})

.controller("InvoiceDetailController", function($scope, $http) {
    $scope.DataInvDetail = [];
    $scope.Init = function() {
        var UrlInvDetailController = "api/InvDetail.php?action=GetInvDetail";
        $http({
                method: "get",
                url: UrlInvDetailController
            })
            .then(function(response) {
                $scope.DataInvDetail = response.data;
            }, function(error) {
                alert(err.Massage);
            })
    }

})

.controller("PenjualanController", function($scope, $http, $location, $filter) {
    $scope.DataPenjualan = [];
    $scope.DataCustomer = [];
    $scope.SelectedItemCustomerAsal = {};
    $scope.SelectedItemCustomerTujuan = {};
    $scope.DataInputPenjualan = {};
    $scope.DataCity = [];
    $scope.LastRecordPenjualan = {};
    $scope.SelectedItemCityAsal = {};
    $scope.SelectedItemCityTujuan = {};
    $scope.SelectedDataHarga = {};
    $scope.DataVia = [
        { port: 'Sea' },
        { port: 'Air' },
        { port: 'Land' }
    ];
    $scope.DataStatusPembayaran = [{ status: 'Credit' }, { status: 'COD' }, { status: 'Cash' }];
    //$scope.DataInputPenjualan={};
    $scope.DataTgl = {};
    $scope.Tampil = false;
    $scope.Init = function() {
        //Get City
        var GetCity = "api/datas/readCity.php";
        $http({
                method: "get",
                url: GetCity
            })
            .then(function(response) {
                $scope.DataCity = response.data.records;
            }, function(error) {
                alert(error.message);
            })

        //Get Customer
        var Getcustomer = "api/datas/readCustomer.php";
        $http({
                method: "get",
                url: Getcustomer
            })
            .then(function(response) {
                $scope.DataCustomer = response.data.records;
            }, function(error) {
                alert(error.message);
            })

        //Get lastrecordpenjualan
        var GetCity = "api/datas/readLastRecordPenjualan.php";
        $http({
                method: "get",
                url: GetCity
            })
            .then(function(response) {
                $scope.LastRecordPenjualan = response.data.records;
                $scope.DataInputPenjualan.STT = parseInt($scope.LastRecordPenjualan[0].STT) + 1;
            }, function(error) {
                alert(error.message);
            })

        if ($scope.Coly == 0) {
            $scope.Tampil = true;
        } else {
            $scope.Tampil = false;
        }

        //Get lastrecordpenjualan
        var GetPenjualan = "api/datas/readPenjualan.php";
        $http({
                method: "get",
                url: GetPenjualan
            })
            .then(function(response) {
                $scope.DataPenjualan = response.data.records;
                angular.forEach($scope.DataPenjualan, function(itemPenjualan, keyP) {
                    angular.forEach($scope.DataCustomer, function(ItemCutomer, keyC) {
                        if (ItemCutomer.Id == itemPenjualan.ShiperID)
                            itemPenjualan.ShiperName = ItemCutomer.Name;
                        else if (ItemCutomer.Id == itemPenjualan.ReciverID)
                            itemPenjualan.ReciverName = ItemCutomer.Name;
                    })
                    angular.forEach($scope.DataCity, function(ItemCity, keyy) {
                        if (ItemCity.Id == itemPenjualan.CityID)
                            itemPenjualan.CityName = ItemCity.CityName;
                    })
                    var Nilai = ((parseInt(itemPenjualan.Price) * parseInt(itemPenjualan.Weight)) + parseInt(itemPenjualan.PackingCosts) + parseInt(itemPenjualan.Etc));
                    var Pajak = parseInt(Nilai) * (parseInt(itemPenjualan.Tax) / 100);
                    itemPenjualan.Total = parseInt(Nilai) + parseInt(Pajak);

                })
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.TestTanggal = function() {
        $scope.DataTgl.TglAwal = $filter('date')($scope.DataTgl.TglAwal, "yyyy-MM-dd");
        var a = $scope.DataTgl;
        alert($scope.DataTgl.TglAwal);

    }

    $scope.SetAsal = function(item) {
        angular.forEach($scope.DataCity, function(value, key) {
            if (value.Id == item.CityID) {
                $scope.SelectedItemCityAsal = value;
            }
        })


    }

    $scope.SetHarga = function() {
        //Get City
        $scope.SelectedDataHarga.ShiperId = $scope.SelectedItemCustomerAsal.Id;
        $scope.SelectedDataHarga.ReciverId = $scope.SelectedItemCustomerTujuan.Id;
        $scope.SelectedDataHarga.PortType = $scope.DataInputPenjualan.PortType.port;
        $scope.SelectedDataHarga.PayType = $scope.DataInputPenjualan.PayType.status;
        $scope.SelectedDataHarga.FromCity = $scope.SelectedItemCityAsal.Id;
        $scope.SelectedDataHarga.ToCity = $scope.SelectedItemCityTujuan.Id;
        $scope.DataInputPenjualan.PackingCosts = "0";
        $scope.DataInputPenjualan.Etc = "0";
        $scope.DataInputPenjualan.Tax = "0";
        var Data = $scope.SelectedDataHarga;
        var GetPrice = "api/datas/readOnePrice.php";
        $http({
                method: "post",
                url: GetPrice,
                data: Data
            })
            .then(function(response) {
                $scope.DataInputPenjualan.Price = response.data.records[0];
                $scope.DataInputPenjualan.Biaya = parseInt($scope.DataInputPenjualan.Price.Price) * parseInt($scope.DataInputPenjualan.Weight);
                $scope.DataInputPenjualan.TotalSementara = parseInt($scope.DataInputPenjualan.Price.Price) * parseInt($scope.DataInputPenjualan.Weight);
                $scope.DataInputPenjualan.Total = angular.copy($scope.DataInputPenjualan.TotalSementara);
            }, function(error) {
                alert(error.message);
            })
    }
    $scope.Packing = function() {
        if ($scope.DataInputPenjualan.PackingCosts == "" || $scope.DataInputPenjualan.PackingCosts == "0") {
            $scope.DataInputPenjualan.PackingCosts = "0";
            $scope.DataInputPenjualan.Total = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.PackingCosts) + parseInt($scope.DataInputPenjualan.Etc) + ((parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.PackingCosts) + parseInt($scope.DataInputPenjualan.Etc)) * (parseInt($scope.DataInputPenjualan.Tax) / 100));
            //$scope.DataInputPenjualan.BiayaPlusPackingCosts = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.PackingCosts) + parseInt($scope.DataInputPenjualan.BiayaPlusEtc) + parseInt($scope.DataInputPenjualan.BiayaPlusTax);
            //$scope.DataInputPenjualan.Total = angular.copy($scope.DataInputPenjualan.BiayaPlusPackingCosts);
            //$scope.DataInputPenjualan.TotalSementara = angular.copy($scope.DataInputPenjualan.Total);
        } else {
            $scope.DataInputPenjualan.Total = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.PackingCosts) + parseInt($scope.DataInputPenjualan.Etc) + ((parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.PackingCosts) + parseInt($scope.DataInputPenjualan.Etc)) * (parseInt($scope.DataInputPenjualan.Tax) / 100));
            //$scope.DataInputPenjualan.BiayaPlusPackingCosts = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.PackingCosts) + parseInt($scope.DataInputPenjualan.BiayaPlusEtc) + parseInt($scope.DataInputPenjualan.BiayaPlusTax);
        }
    }

    $scope.Etc = function() {
        if ($scope.DataInputPenjualan.Etc == "" || $scope.DataInputPenjualan.Etc == "0") {
            $scope.DataInputPenjualan.Etc = "0";
            $scope.DataInputPenjualan.Total = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts) + ((parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts)) * (parseInt($scope.DataInputPenjualan.Tax) / 100));
            //$scope.DataInputPenjualan.BiayaPlusEtc = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.BiayaPlusPackingCosts) + parseInt($scope.DataInputPenjualan.BiayaPlusTax);
        } else {
            $scope.DataInputPenjualan.Total = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts) + ((parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts)) * (parseInt($scope.DataInputPenjualan.Tax) / 100));
            //$scope.DataInputPenjualan.BiayaPlusEtc = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.BiayaPlusPackingCosts) + parseInt($scope.DataInputPenjualan.BiayaPlusTax);
        }
    }

    $scope.Tax = function() {
        if ($scope.DataInputPenjualan.Tax == "" || $scope.DataInputPenjualan.Tax == "0") {
            $scope.DataInputPenjualan.Tax = "0";
            $scope.DataInputPenjualan.Total = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts) + ((parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts)) * (parseInt($scope.DataInputPenjualan.Tax) / 100));
            $scope.DataInputPenjualan.BiayaPlusTax = (parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.BiayaPlusEtc) + parseInt($scope.DataInputPenjualan.BiayaPlusPackingCosts)) - parseInt($scope.DataInputPenjualan.BiayaTax);
        } else {
            $scope.DataInputPenjualan.Total = parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts) + ((parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.PackingCosts)) * (parseInt($scope.DataInputPenjualan.Tax) / 100));
            //$scope.DataInputPenjualan.BiayaTax = (parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.BiayaPlusEtc) + parseInt($scope.DataInputPenjualan.BiayaPlusPackingCosts)) * parseFloat(parseInt($scope.DataInputPenjualan.Tax) / 100);
            //$scope.DataInputPenjualan.Total = (parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.BiayaPlusEtc) + parseInt($scope.DataInputPenjualan.BiayaPlusPackingCosts)) - parseInt($scope.DataInputPenjualan.BiayaTax);
            //$scope.DataInputPenjualan.BiayaPlusTax = (parseInt($scope.DataInputPenjualan.Biaya) + parseInt($scope.DataInputPenjualan.Etc) + parseInt($scope.DataInputPenjualan.BiayaPlusPackingCosts)) - parseInt($scope.DataInputPenjualan.BiayaTax);
        }
    }

    $scope.SetTujuan = function(item) {
        angular.forEach($scope.DataCity, function(value, key) {
            if (value.Id == item.CityID) {
                $scope.SelectedItemCityTujuan = value;
            }
        })

    }


    //Insert Penjualan
    $scope.InsertPenjualan = function() {
        $scope.DataInputPenjualan.ShiperID = $scope.SelectedItemCustomerAsal.Id;
        $scope.DataInputPenjualan.ReciverID = $scope.SelectedItemCustomerTujuan.Id;
        $scope.DataInputPenjualan.CityID = $scope.SelectedItemCityTujuan.Id;
        var Data = $scope.DataInputPenjualan;
        var UrlInsertPenjualan = "api/datas/createPenjualan.php";
        $http({
                method: "port",
                url: UrlInsertPenjualan,
                data: Data
            })
            .then(function(response) {
                if (response.data.message) {
                    $location.path("/Penjualan")
                }
                //Data.Id = response.data.message
            }, function(error) {
                alert(error.message);
            })

    }

})

.controller("PricesController", function($scope, $http) {
    $scope.DataPrices = [];
    $scope.Init = function() {
        var UrlPrices = "api/datas/readPrice.php";
        $http({
                method: "get",
                url: UrlPrices
            })
            .then(function(response) {
                $scope.DataPrices = response.data.records;
            }, function(error) {
                alert(error.message);
            })
    }

})

.controller("InvoicesController", function($scope, $http) {

})


.controller("CollesController", function($scope, $http) {

});
angular.module("Ctrl", [])


.controller("MainController", function($scope, $http, $rootScope, SessionService) {
    $scope.DataAuth = {};
    $rootScope.Session = {};

    $scope.Init = function() {

        //Get Auth

        $scope.Title = "Ini Judul Dari Controller";
    }
})

.controller("CityController", function($scope, $http, $rootScope, SessionService) {
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

.controller("UserController", function($scope, $http, SessionService) {
    $scope.DataUsers = [];
    $scope.DataSelected = {};
    $scope.InputUser = {};
    $scope.DataJabatan = [
        { Jabatan: 'Admin' }, { Jabatan: 'Bendahara' }, { Jabatan: 'StafOps' }
    ];
    $scope.SelectJabatan = {};

    $scope.Init = function() {
        var UrlUser = "api/datas/readUsers.php";
        $http({
                method: "get",
                url: UrlUser
            })
            .then(function(response) {
                $scope.DataUsers = response.data.records;
            }, function(error) {
                alert(error.message);
            })
    }
    $scope.SelectedUser = function(item) {
        $scope.DataSelected = item;
        $scope.SelectJabatan.Jabatan = item.Jabatan;
    }

    //Funsi Insert User
    $scope.InsertDataUser = function() {
        var UrlUsers = "api/datas/createUsers.php";
        $scope.InputUser.Jabatan = $scope.SelectJabatan.Jabatan.Jabatan;
        var Datasimpan = $scope.InputUser;
        $http({
                method: "post",
                url: UrlUsers,
                data: Datasimpan
            })
            .then(function(response) {
                if (response.data.message > 0) {
                    Datasimpan.Id = response.data;
                    $scope.DataUsers.push(angular.copy(Datasimpan));
                    $scope.InputUser = {};
                }
            }, function(error) {
                alert(error.message);
            })
    }
})

.controller("CustomerController", function($scope, $http, SessionService) {
    $scope.DataCustomer = [];
    $scope.InputCustomer = {};
    $scope.DataCity = [];
    $scope.SelectedItemCity = {};
    $scope.CustomerType = [{ 'Type': 'Organization' }, { 'Type': 'Person' }];
    $scope.SelectedCusType = {};
    $scope.DataUpdateCustomer = {};
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
    }

    $scope.InsertDataCustomer = function() {
        $scope.InputCustomer.CityID = $scope.SelectedItemCity.Id;
        $scope.InputCustomer.CustomerType = $scope.SelectedCusType.Type;
        var Data = angular.copy($scope.InputCustomer);
        var UrlInsertCustomer = "api/datas/createCustomer.php"
        $http({
                method: "post",
                url: UrlInsertCustomer,
                data: Data
            })
            .then(function(response) {
                Data.Id = response.data.message;
                $scope.DataCustomer.push(Data);

            }, function(error) {
                alert(error.message);
            })
        $scope.InputCustomer = {};
        $scope.SelectedItemCity = {};
        $scope.SelectedCusType = {};
    }

    $scope.SelectedCustomer = function(item) {
        $scope.DataUpdateCustomer = item;
        $scope.SelectedCusType.Type = item.CustomerType;
        angular.forEach($scope.DataCity, function(ItemCity, keyy) {
            if (ItemCity.Id == item.CityID)
                $scope.SelectedItemCity = ItemCity;
        })
    }

    $scope.UpdateDataCustomer = function() {
        $scope.DataUpdateCustomer.CityID = $scope.SelectedItemCity.Id;
        $scope.DataUpdateCustomer.CustomerType = $scope.SelectedCusType.Type;
        var Data = angular.copy($scope.DataUpdateCustomer);
        var UrlUpdateCustomer = "api/datas/updateCustomer.php"
        $http({
                method: "post",
                url: UrlUpdateCustomer,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Customer Was Update") {
                    angular.forEach($scope.DataCustomer, function(value, key) {
                        if (value.Id == Data.Id) {
                            value.Name = Data.Name;
                            value.CustomerType = Data.CustomerType;
                            value.ContactName = Data.ContactName;
                            value.Phone1 = Data.Phone1;
                            value.Phone2 = Data.Phone2;
                            value.Handphone = Data.Handphone;
                            value.Address = Data.Address;
                            value.Email = Data.Email;
                            value.CityID = Data.CityID;
                            value.CityName = Data.CityName
                        }
                    })
                    alert(response.data.message);
                } else
                    alert("Gagal Update");
            }, function(error) {
                alert(error.message);
            })
    }
})


.controller("PenjualanController", function($scope, $http, $location, $filter, $rootScope, SessionService) {
    $scope.DataPenjualan = [];
    $scope.DataCustomer = [];
    $scope.SelectedItemCustomerAsal = {};
    $scope.SelectedItemCustomerTujuan = {};
    $scope.DataInputPenjualan = {};
    $scope.DataCity = [];
    $scope.LastRecordPenjualan = {};
    $scope.SelectedItemCityAsal = {};
    $scope.SelectedItemCityTujuan = {};
    $scope.SelectedItemPayType = {};
    $scope.SelectedItemPortType = {};
    $scope.SelectedItemPrice = {};
    $scope.SelectedDataHarga = {};
    $scope.ItemCetak = {};
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

        //Get lastrecordpenjualan untuk nomer STT baru
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



        //Get lastrecordpenjualan
        var GetPenjualan = "api/datas/readPenjualan.php";
        $http({
                method: "get",
                url: GetPenjualan
            })
            .then(function(response) {
                $scope.DataPenjualan = response.data.records;
                angular.forEach($scope.DataPenjualan, function(itemPenjualan, keyP) {
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
        $scope.SelectedDataHarga.PortType = $scope.SelectedItemPortType.port;
        $scope.SelectedDataHarga.PayType = $scope.SelectedItemPayType.status;
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
                if (response.data.num > 0) {
                    $scope.SelectedItemPrice = response.data.records[0];
                    $scope.DataInputPenjualan.Biaya = parseInt($scope.SelectedItemPrice.Price) * parseInt($scope.DataInputPenjualan.Weight);
                    $scope.DataInputPenjualan.TotalSementara = parseInt($scope.SelectedItemPrice.Price) * parseInt($scope.DataInputPenjualan.Weight);
                    $scope.DataInputPenjualan.Total = angular.copy($scope.DataInputPenjualan.TotalSementara);
                    $scope.DataInputPenjualan.Price = $scope.SelectedItemPrice.Price;
                } else {
                    $scope.SelectedItemPrice = null;
                    alert("Tidak Harga untuk Item yang bersangkutan");
                }


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
        $scope.DataInputPenjualan.ShiperName = $scope.SelectedItemCustomerAsal.Name;
        $scope.DataInputPenjualan.ReciverID = $scope.SelectedItemCustomerTujuan.Id;
        $scope.DataInputPenjualan.ReciverName = $scope.SelectedItemCustomerTujuan.Name;
        $scope.DataInputPenjualan.CityID = $scope.SelectedItemCityTujuan.Id;
        $scope.DataInputPenjualan.CityName = $scope.SelectedItemCityTujuan.CityName;
        $scope.DataInputPenjualan.PortType = $scope.SelectedItemPortType.port;
        $scope.DataInputPenjualan.PayType = $scope.SelectedItemPayType.status;

        var Data = $scope.DataInputPenjualan;
        var UrlInsertPenjualan = "api/datas/createPenjualan.php";
        $http({
                method: "post",
                url: UrlInsertPenjualan,
                data: Data
            })
            .then(function(response) {
                if (response.data.message) {
                    var UrlCetakNota = "api/datas/cetakNota.php";
                    $http({
                            method: "post",
                            url: UrlCetakNota,
                            data: Data
                        })
                        .then(function(response) {
                            window.open('apps/Report/Notaa.html', '_blank');
                            $location.path("/Penjualan");
                        }, function(error) {
                            alert(error.message);
                        })

                }
                //Data.Id = response.data.message
            }, function(error) {
                alert(error.message);
            })

    }

    $scope.Cetak = function(item) {
        $scope.ItemCetak = item;
        var Data = $scope.ItemCetak;
        var UrlCetakNota = "api/datas/cetakNota.php";
        $http({
                method: "post",
                url: UrlCetakNota,
                data: Data
            })
            .then(function(response) {
                window.open('apps/Report/Notaa.html', '_blank');

            }, function(error) {
                alert(error.message);
            })
    }

})

.controller("PricesController", function($scope, $http, $rootScope, SessionService) {
    $scope.DataPrices = [];
    $scope.DataCity = [];
    $scope.DataCustomer = [];
    $scope.SelectedShiper = {};
    $scope.SelectedReciver = {};
    $scope.SelectedFromCity = {};
    $scope.SelectedToCity = {};
    $scope.InputPrice = {};
    $scope.PortType = [{ 'port': 'Sea' }, { 'port': 'Air' }, { 'port': 'Land' }];
    $scope.SelectedPort = {};
    $scope.PayType = [{ 'pay': 'Credit' }, { 'pay': 'COD' }, { 'pay': 'Cash' }];
    $scope.SelectedPay = {};
    $scope.DataSelectedItem = {};
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

    $scope.InsertPrice = function() {
        $scope.InputPrice.ShiperId = $scope.SelectedShiper.Id;
        $scope.InputPrice.ShiperName = $scope.SelectedShiper.Name;
        $scope.InputPrice.ReciverId = $scope.SelectedReciver.Id;
        $scope.InputPrice.ReciverName = $scope.SelectedReciver.Name;
        $scope.InputPrice.FromCity = $scope.SelectedFromCity.Id;
        $scope.InputPrice.FromCityName = $scope.SelectedFromCity.CityName;
        $scope.InputPrice.ToCity = $scope.SelectedToCity.Id;
        $scope.InputPrice.ToCityName = $scope.SelectedToCity.CityName;
        $scope.InputPrice.PortType = $scope.SelectedPort.port;
        $scope.InputPrice.PayType = $scope.SelectedPay.pay;
        var Data = angular.copy($scope.InputPrice);
        var UrlInserPrice = "api/datas/createPrice.php";
        $http({
                method: "post",
                url: UrlInserPrice,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Unable to create Price") {
                    Data.Id = response.data.message;
                    $scope.DataPrices.push(Data);

                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            });
        $scope.InputPrice = {};
        $scope.SelectedShiper = {};
        $scope.SelectedReciver = {};
        $scope.SelectedFromCity = {};
        $scope.SelectedToCity = {};
        $scope.SelectedPort = {};
        $scope.SelectedPay = {};
    }
    $scope.SelectedPrice = function(item) {
        $scope.DataSelectedItem = item;
        $scope.SelectedPort.port = $scope.DataSelectedItem.PortType;
        $scope.SelectedPay.pay = $scope.DataSelectedItem.PayType;
        angular.forEach($scope.DataCustomer, function(valueCustom, KeyCustom) {
            if (valueCustom.Id == $scope.DataSelectedItem.ShiperId) {
                $scope.SelectedShiper = valueCustom;
            }
            if (valueCustom.Id == $scope.DataSelectedItem.ReciverId) {
                $scope.SelectedReciver = valueCustom;
            }
        })

        angular.forEach($scope.DataCity, function(ValCity, KeyCity) {
            if (ValCity.Id == $scope.DataSelectedItem.FromCity) {
                $scope.SelectedFromCity = ValCity;
            }
            if (ValCity.Id == $scope.DataSelectedItem.ToCity) {
                $scope.SelectedToCity = ValCity;
            }

        })
    }
    $scope.UpdateDataPrice = function() {
        $scope.DataSelectedItem.ShiperId = $scope.SelectedShiper.Id;
        $scope.DataSelectedItem.ShiperName = $scope.SelectedShiper.Name;
        $scope.DataSelectedItem.ReciverId = $scope.SelectedReciver.Id;
        $scope.DataSelectedItem.ReciverName = $scope.SelectedReciver.Name;
        $scope.DataSelectedItem.FromCity = $scope.SelectedFromCity.Id;
        $scope.DataSelectedItem.FromCityName = $scope.SelectedFromCity.CityName;
        $scope.DataSelectedItem.ToCity = $scope.SelectedToCity.Id;
        $scope.DataSelectedItem.ToCityName = $scope.SelectedToCity.CityName;
        $scope.DataSelectedItem.PortType = $scope.SelectedPort.port;
        $scope.DataSelectedItem.PayType = $scope.SelectedPay.pay;
        var Data = angular.copy($scope.DataSelectedItem);
        var UrlUpdatePrice = "api/datas/updatePrice.php";
        $http({
                method: "post",
                url: UrlUpdatePrice,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Price Was Update") {
                    Data.Id = response.data.message;
                    $scope.DataPrices.push(Data);

                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            });
    }

})

.controller("InvoicesController", function($scope, $http, SessionService) {
    $scope.Datasinvoice = [];
    $scope.DataDetail = [];
    $scope.DataInputInvoice = {};
    $scope.DataCustomer = [];
    $scope.DatasPenjualan = [];
    $scope.DatasPenjualanNew = [];
    $scope.SelectedItemCustomer = {};
    $scope.STT = [];
    $scope.DataChecked = {};
    $scope.PayType = [{ pay: 'Transfer' }, { pay: 'Chash' }];
    $scope.DataStatus = [{ status: 'Paid' }, { status: 'Pending' }, { status: 'Cancel' }];
    $scope.SelectedItemPay = {};
    $scope.DataUbah = {};
    $scope.SelectedDataStatus = {};
    $scope.Init = function() {
        var Getinv = "api/datas/readInvoices.php";
        $http({
                method: "get",
                url: Getinv
            })
            .then(function(response) {
                $scope.Datasinvoice = response.data.records;
            }, function(error) {
                alert(error.message);
            })


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

        var Getinvdet = "api/datas/readInvoiceDetail.php";
        $http({
                method: "get",
                url: Getinvdet
            })
            .then(function(response) {
                $scope.DataDetail = response.data.records;
            }, function(error) {
                alert(error.message);
            })

    }

    $scope.SetPelanggan = function() {
        var Data = $scope.SelectedItemCustomer;
        var Getpenjualan = "api/datas/readPenjualanByCustomer.php";
        $http({
                method: "post",
                url: Getpenjualan,
                data: Data

            })
            .then(function(response) {
                $scope.DatasPenjualan = response.data.records;
                angular.forEach($scope.DatasPenjualan, function(itemPenjualan, keyP) {
                    var a = 0;
                    angular.forEach($scope.DataDetail, function(Iteminvdet, keyinvdet) {
                        if (Iteminvdet.STT == itemPenjualan.STT)
                            a += 1;
                    })
                    if (a == 0)
                        $scope.DatasPenjualanNew.push(itemPenjualan);

                })

                angular.forEach($scope.DatasPenjualanNew, function(itemPenjualan, keyP) {
                    angular.forEach($scope.DataCustomer, function(ItemCutomer, keyC) {
                        if (ItemCutomer.Id == itemPenjualan.ShiperID)
                            itemPenjualan.ShiperName = ItemCutomer.Name;
                        else if (ItemCutomer.Id == itemPenjualan.ReciverID)
                            itemPenjualan.ReciverName = ItemCutomer.Name;
                    })

                    var Nilai = ((parseInt(itemPenjualan.Price) * parseInt(itemPenjualan.Weight)) + parseInt(itemPenjualan.PackingCosts) + parseInt(itemPenjualan.Etc));
                    var Pajak = parseInt(Nilai) * (parseInt(itemPenjualan.Tax) / 100);
                    itemPenjualan.Total = parseInt(Nilai) + parseInt(Pajak);

                })





            }, function(error) {
                alert(error.message);
            })
    }

    $scope.Check = function(check, item) {
        angular.forEach($scope.DatasPenjualan, function(value, key) {
            if (value.Id == item.Id) {
                if (value.Cheked != undefined) {
                    if (check == true)
                        value.Cheked = check;
                    else
                        value.Cheked = false;
                } else {
                    if (check == true)
                        value.Cheked = check;
                    else
                        value.Cheked = false;
                }
            }
        })

    }

    $scope.AddSTT = function() {
        angular.forEach($scope.DatasPenjualan, function(value, key) {
            var Data = 0;
            if ($scope.STT.length != 0) {
                angular.forEach($scope.STT, function(val, keyval) {
                    if (val.STT == value.STT) {
                        Data += 1;
                    }
                })
                if (Data == 0 && value.Cheked == true)
                    $scope.STT.push(value);
                else if (Data > 0 && value.Cheked == false) {
                    $scope.STT.splice(value, 1);
                }
            } else {
                if (value.Cheked == true) {
                    $scope.STT.push(value);
                }
            }
        })
        $scope.DataInputInvoice.STT = $scope.STT;
    }

    $scope.CreateInv = function() {
        $scope.DataInputInvoice.InvoicePayType = $scope.SelectedItemPay.pay;
        $scope.DataInputInvoice.CustomerId = $scope.SelectedItemCustomer.Id;
        $scope.DataInputInvoice.InvoiceStatus = "Pending";
        var Data = $scope.DataInputInvoice;
        var UrlInv = "api/datas/createInv.php";
        $http({
                method: "post",
                url: UrlInv,
                data: Data
            })
            .then(function(response) {
                angular.forEach(response.data.STT, function(Value, Key) {
                    angular.forEach(Data.STT, function(Val, NewKey) {

                    })
                })
                $scope.Datasinvoice = Data;
            }, function(error) {
                alert(error.message);
            })

    }
    $scope.Print = function(item) {
        var Data = item;
        var UrlCetak = "api/datas/cetakInv.php";
        $http({
                method: "post",
                url: UrlCetak,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Success")
                    window.open('apps/Report/Invoice.html', '_blank');
            }, function(error) {
                alert(error.message);
            })

    }

    $scope.SelectedEdit = function(item) {
        $scope.DataUbah = item;

    }

    $scope.UpdateData = function() {
        $scope.DataUbah.Paid = $scope.SelectedDataStatus.status;
        var Data = $scope.DataUbah;
        var UrlUpdateStatusBayar = "api/datas/updatePaid.php";
        $http({
                method: "post",
                url: UrlUpdateStatusBayar,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Invoice Was Update") {
                    angular.forEach($scope.Datasinvoice, function(value, key) {
                        if (value.Id == Data.Id) {
                            value.InvoiceStatus = Data.Paid;
                            value.PaidDate = Data.PayDate;
                        }
                    })
                    alert("Invoice Was Update");
                }
            }, function(error) {
                alert(error.message);
            })
    }

})


.controller("LogController", function($scope, $http) {
    $scope.Init = function() {
        var Getlog = "api/datas/logout.php";
        $http({
                method: "get",
                url: Getlog
            })
            .then(function(response) {
                if (response.data.message == true)
                    window.location.href = 'System/pages/sign-in.html';
            }, function(error) {
                alert(error.message);
            })
    }



})

.controller("LaporanController", function($scope, $http) {
    $scope.DataPenjualan = [];
    $scope.DataSearch = {};
    $scope.StatusPay = [{ IsPaid: 'Lunas' }, { IsPaid: 'Piutang' }];
    $scope.SelectedItemPaid = {};
    $scope.Init = function() {

    }

    $scope.Cari = function() {
        var GetPenjualan = "api/datas/readPenjualanByDate.php";
        if ($scope.SelectedItemPaid.IsPaid == "Lunas")
            $scope.DataSearch.IsPaid = "true";
        else
            $scope.DataSearch.IsPaid = "false";
        var Data = $scope.DataSearch;
        $http({
                method: "post",
                url: GetPenjualan,
                data: Data
            })
            .then(function(response) {
                $scope.DataPenjualan = response.data.records;
                angular.forEach($scope.DataPenjualan, function(itemPenjualan, keyP) {
                    var Nilai = ((parseInt(itemPenjualan.Price) * parseInt(itemPenjualan.Weight)) + parseInt(itemPenjualan.PackingCosts) + parseInt(itemPenjualan.Etc));
                    var Pajak = parseInt(Nilai) * (parseInt(itemPenjualan.Tax) / 100);
                    itemPenjualan.Total = parseInt(Nilai) + parseInt(Pajak);

                })
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.Cetak = function() {
        var GetPenjualan = "api/datas/readPenjualanByDate.php";
        if ($scope.SelectedItemPaid.IsPaid == "Lunas")
            $scope.DataSearch.IsPaid = "true";
        else
            $scope.DataSearch.IsPaid = "false";
        var Data = $scope.DataSearch;
        var UrlCetak = "api/datas/cetakLaporan.php";
        $http({
                method: "post",
                url: UrlCetak,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Success")
                    window.open('apps/Report/LaporanPenjualan.html', '_blank');
            }, function(error) {
                alert(error.message);
            })

    }



})

;
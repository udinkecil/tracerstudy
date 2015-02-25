'use strict';

MetronicApp
    .controller('TracerStudyController', function($rootScope, $scope, TracerService, JurusanService, $modal) {

        $scope.formData = {
            'status': { 'lulus': true, 'aktif':false }
        };

        JurusanService.fetch().then(function(){
            $scope.jurusanItems = JurusanService.data();
        });

        $scope.orderByField = 'nimhs';
        $scope.reverseSort = true;
        $scope.maxSize = 10;

        function assignForm(sort) {
            var form = {};

            form.nimhs      = $scope.formData.nimhs || null;
            form.nmmhs      = $scope.formData.nama || null;
            form.kdjur      = ($scope.formData.jurusan) ? $scope.formData.jurusan.kode_jurusan : null;
            form.status     = $scope.formData.status;
            form.start_ipk  = $scope.formData.start_ipk || null;
            form.end_ipk    = $scope.formData.end_ipk || null;
            form.start_year = $scope.formData.start_year || null;
            form.end_year   = $scope.formData.end_year || null;

            form.sort       = sort || { field: 'nimhs', sort: true }

            return form;
        };

        $scope.pageChanged = function() {
            var form = assignForm();

            var list = TracerService.getPageMahasiswa(form, $scope.bigCurrentPage);

            list.then(
                function(payload) {
                    $scope.mahasiswaItems = payload.data.data;

                    $scope.bigTotalItems  = payload.data.meta.pagination.total;
                    $scope.bigCurrentPage = payload.data.meta.pagination.current_page;
                }
            );
        };

        $scope.sortData = function (field) {
            $scope.orderByField = field;
            $scope.reverseSort = !$scope.reverseSort;

            var sort = { field: $scope.orderByField, sort: $scope.reverseSort }

            var form = assignForm(sort);

            var list = TracerService.getMahasiswa(form);

            list.then(
                function(payload) {
                    $scope.mahasiswaItems = payload.data.data;

                    $scope.bigTotalItems  = payload.data.meta.pagination.total;
                    $scope.bigCurrentPage = payload.data.meta.pagination.current_page;
                }
            );
        };

        $scope.getListMahasiswa = function() {
            var form = assignForm();

            var list = TracerService.getMahasiswa(form);

            list.then(
                function(payload) {

                    var result = payload.data;

                    if (result.meta.pagination.total == 0) {
                        $scope.alerts = [
                            { type: 'danger', msg: 'Data mahasiswa tidak ditemukan.' },
                        ];
                        return false;
                    }

                    $scope.alerts = [];
                    $scope.mahasiswaItems = result.data;

                    $scope.bigTotalItems  = result.meta.pagination.total;
                    $scope.bigCurrentPage = result.meta.pagination.current_page;

                    Metronic.scrollTo($('body'), 600);
                }
            );
        };

        $scope.open = function (mahasiswa) {
            $scope.mahasiswa = mahasiswa;
            $modal.open({
                templateUrl: 'assets/views/profile.html',
                size: 'lg',
                scope: $scope,
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            name: 'MetronicApp',
                            files: [
                                'assets/admin/pages/css/profile.css',
                            ]
                        });
                    }]
                }
            });
        };

        $scope.$on('$viewContentLoaded', function() {
            Metronic.initAjax();
        });
})
    .factory('TracerService', function($http){
        return {
            getMahasiswa: function(formObj) {
                return $http.post( '/search', formObj );
            },
            getPageMahasiswa: function(formObj, page) {
                return $http.post( '/search?page='+page, formObj );
            }
        }
})
    .factory('JurusanService', function($http){
        var JurusanService = {};
        var data = [];

        JurusanService.fetch = function() {
            return $http.get('/jurusan')
                .then(
                    function (payload) {
                        data = payload.data;
                        return data;
                    }
                );
        };

        JurusanService.data = function() { return data.data; }

        return JurusanService;
    });
"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
// Importar el núcleo de Angular
var ciudadanoVehiculo_service_1 = require("../../services/ciudadanoVehiculo/ciudadanoVehiculo.service");
var vehiculo_service_1 = require("../../services/vehiculo/vehiculo.service");
var ciudadano_service_1 = require("../../services/ciudadano/ciudadano.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var new_vehiculo_component_1 = require('../../components/vehiculo/new.vehiculo.component');
var new_ciudadano_component_1 = require('../../components/ciudadano/new.ciudadano.component');
var CiudadanoVehiculo_1 = require('../../model/CiudadanoVehiculo/CiudadanoVehiculo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexSubirCarpetaComponent = (function () {
    function IndexSubirCarpetaComponent(_VehiculoService, _CiudadanoService, _CiudadanoVehiculoService, _loginService, _route, _router) {
        this._VehiculoService = _VehiculoService;
        this._CiudadanoService = _CiudadanoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(null, null, null, "", "", "", "");
    }
    IndexSubirCarpetaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.placa = {
            'placa': this.placa,
        };
        this._route.params.subscribe(function (params) {
            _this.tramiteId = +params["tramiteId"];
        });
        var token = this._loginService.getToken();
    };
    IndexSubirCarpetaComponent.prototype.onKey = function (event) {
        var _this = this;
        var token = this._loginService.getToken();
        console.log(this.placa);
        this._VehiculoService.showVehiculoPlaca(token, this.placa).subscribe(function (response) {
            _this.vehiculo = response.data;
            var status = response.status;
            if (status == 'error') {
                _this.validate = false;
                _this.validateCiudadano = false;
                _this.crear = true;
                _this.claseSpan = "glyphicon glyphicon-remove form-control-feedback";
                _this.clase = "form-group has-error has-feedback";
                _this.activar = false;
            }
            else {
                _this.claseSpan = "glyphicon glyphicon-ok form-control-feedback";
                _this.clase = "form-group has-success has-feedback";
                _this.msg = response.msj;
                _this.crear = false;
                _this.validate = true;
                _this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token, _this.vehiculo.id).subscribe(function (response) {
                    _this.ciudadanosVehiculo = response.data;
                    _this.respuesta = response;
                    if (_this.respuesta.status == 'error') {
                        _this.activar = true;
                        _this.validateCiudadano = false;
                    }
                    else {
                        _this.activar = true;
                        _this.validate = true;
                        _this.validateCiudadano = true;
                    }
                }, function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onChangeCiudadano = function (id) {
        this.idCiudadanoSeleccionado = id;
        console.log(this.idCiudadanoSeleccionado);
    };
    IndexSubirCarpetaComponent.prototype.vheiculoCreado = function (event) {
        this.placa.placa = event;
        this.onKey("");
    };
    IndexSubirCarpetaComponent.prototype.onKeyCiudadano = function (event) {
        var _this = this;
        var identificacion = {
            'numeroIdentificacion': event,
        };
        var token = this._loginService.getToken();
        this._CiudadanoService.showCiudadanoCedula(token, identificacion).subscribe(function (response) {
            _this.ciudadano = response.data;
            var status = response.status;
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].ciudadano.numeroIdentificacion == event) {
                        var existe = true;
                    }
                }
            }
            if (existe) {
                alert("existe una relacion con el ciudadano");
            }
            else {
                if (status == 'error') {
                    _this.validateCedula = false;
                    _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                    _this.calseCedula = "form-group has-error has-feedback";
                }
                else {
                    _this.validateCedula = true;
                    _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                    _this.calseCedula = "form-group has-success has-feedback";
                    _this.msgCiudadano = response.msj;
                }
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.VehiculoCiudadano = function () {
        var _this = this;
        this.ciudadanoVehiculo.ciudadanoId = this.ciudadano.numeroIdentificacion;
        this.ciudadanoVehiculo.vehiculoId = this.vehiculo.placa;
        var token = this._loginService.getToken();
        this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo, token).subscribe(function (response) {
            _this.respuesta = response;
            if (_this.respuesta.status == 'success') {
                _this.validateCedula = false;
                _this.onKey("");
            }
            console.log(_this.respuesta);
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    IndexSubirCarpetaComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/subirCarpeta/index.component.html',
            directives: [router_1.ROUTER_DIRECTIVES, new_vehiculo_component_1.NewVehiculoComponent, new_ciudadano_component_1.NewCiudadanoComponent],
            providers: [login_service_1.LoginService, vehiculo_service_1.VehiculoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, ciudadano_service_1.CiudadanoService]
        }), 
        __metadata('design:paramtypes', [vehiculo_service_1.VehiculoService, ciudadano_service_1.CiudadanoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexSubirCarpetaComponent);
    return IndexSubirCarpetaComponent;
}());
exports.IndexSubirCarpetaComponent = IndexSubirCarpetaComponent;
//# sourceMappingURL=index.subirCarpeta.component.js.map
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
var modulo_service_1 = require("../../../services/modulo/modulo.service");
var ciudadanoVehiculo_service_1 = require("../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service");
var color_service_1 = require("../../../services/color/color.service");
var vehiculo_service_1 = require("../../../services/vehiculo/vehiculo.service");
var tramite_service_1 = require("../../../services/tramite/tramite.service");
var login_service_1 = require("../../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexTramiteCambioColorComponent = (function () {
    function IndexTramiteCambioColorComponent(_ColorService, _VehiculoService, _CiudadanoVehiculoService, _TramiteService, _ModuloService, _loginService, _route, _router) {
        this._ColorService = _ColorService;
        this._VehiculoService = _VehiculoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._TramiteService = _TramiteService;
        this._ModuloService = _ModuloService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    IndexTramiteCambioColorComponent.prototype.ngOnInit = function () {
        var _this = this;
        this._route.params.subscribe(function (params) {
            _this.tramiteId = +params["tramiteId"];
        });
        var token = this._loginService.getToken();
        this._TramiteService.showTramite(token, this.tramiteId).subscribe(function (response) {
            _this.tramite = response.data;
            console.log(_this.tramite);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._ColorService.getColor().subscribe(function (response) {
            _this.colores = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexTramiteCambioColorComponent.prototype.onKey = function (event) {
        var _this = this;
        var token = this._loginService.getToken();
        var values = event.target.value;
        var placa = {
            'placa': values,
        };
        this._VehiculoService.showVehiculoPlaca(token, placa).subscribe(function (response) {
            _this.vehiculo = response.data;
            var status = response.status;
            if (status == 'error') {
                _this.validate = false;
                _this.validateCiudadano = false;
                _this.claseSpan = "glyphicon glyphicon-remove form-control-feedback";
                _this.clase = "form-group has-error has-feedback";
            }
            else {
                _this.validate = true;
                _this.claseSpan = "glyphicon glyphicon-ok form-control-feedback";
                _this.clase = "form-group has-success has-feedback";
                _this.msg = response.msj;
                _this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token, _this.vehiculo.id).subscribe(function (response) {
                    _this.ciudadanosVehiculo = response.data;
                    _this.respuesta = response;
                    if (_this.respuesta.status == 'error') {
                        _this.activar = true;
                        _this.validateCiudadano = false;
                    }
                    else {
                        _this.activar = false;
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
    IndexTramiteCambioColorComponent.prototype.onChangeCiudadano = function (id) {
        this.idCiudadanoSeleccionado = id;
        console.log(this.idCiudadanoSeleccionado);
    };
    IndexTramiteCambioColorComponent.prototype.onChangeColorNuevo = function (colorId) {
        this.colorNuevo = colorId;
        this.finalizar = true;
    };
    IndexTramiteCambioColorComponent.prototype.FinalizarTramite = function () {
        alert("color nuevo:" + this.colorNuevo +
            "ciudadano:" + this.idCiudadanoSeleccionado +
            "vehiculo:" + this.vehiculo.placa +
            "tramite:" + this.tramiteId);
    };
    IndexTramiteCambioColorComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/tipoTramite/cambioColor/index.component.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, modulo_service_1.ModuloService, tramite_service_1.TramiteService, vehiculo_service_1.VehiculoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, color_service_1.ColorService]
        }), 
        __metadata('design:paramtypes', [color_service_1.ColorService, vehiculo_service_1.VehiculoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, tramite_service_1.TramiteService, modulo_service_1.ModuloService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexTramiteCambioColorComponent);
    return IndexTramiteCambioColorComponent;
}());
exports.IndexTramiteCambioColorComponent = IndexTramiteCambioColorComponent;
//# sourceMappingURL=index.tramiteCambioColor.component.js.map
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
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var login_service_1 = require('../../services/login.service');
var tramiteGeneral_service_1 = require('../../services/tramiteGeneral/tramiteGeneral.service');
var vehiculo_service_1 = require('../../services/vehiculo/vehiculo.service');
var TramiteGeneral_1 = require('../../model/tramiteGeneral/TramiteGeneral');
var CiudadanoVehiculo_1 = require('../../model/CiudadanoVehiculo/CiudadanoVehiculo');
var ciudadanoVehiculo_service_1 = require("../../services/ciudadanoVehiculo/ciudadanoVehiculo.service");
// Decorador component, indicamos en que etiqueta se va a cargar la  
var NewTramiteGeneralComponent = (function () {
    function NewTramiteGeneralComponent(_TramiteGeneralService, _VehiculoService, _loginService, _route, _CiudadanoVehiculoService, _router) {
        this._TramiteGeneralService = _TramiteGeneralService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._router = _router;
        this.vehiculoId = null;
        this.ciudadanoId = null;
        this.empresaId = null;
        this.Apoderado = null;
        this.tramiteGeneralCreado = new core_1.EventEmitter();
    }
    NewTramiteGeneralComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteGeneral = new TramiteGeneral_1.TramiteGeneral(null, this.vehiculoId, null, "", "", null, null, null, "", null, this.empresaId, this.ciudadanoId);
        var token = this._loginService.getToken();
        this._VehiculoService.getVehiculo().subscribe(function (response) {
            _this.vehiculos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewTramiteGeneralComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token, this.vehiculoId).subscribe(function (response) {
            _this.ciudadanosVehiculo = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this.tramiteGeneral.apoderado = this.Apoderado;
        this._TramiteGeneralService.register(this.tramiteGeneral, token).subscribe(function (response) {
            _this.respuesta = response;
            console.log(_this.tramiteGeneral);
            if (_this.respuesta.status == "success") {
                for (var i in _this.ciudadanosVehiculo) {
                    var ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(_this.ciudadanosVehiculo[i].id, _this.ciudadanoId, _this.ciudadanosVehiculo[i].vehiculo.placa, _this.empresaId, _this.tramiteGeneral.numeroLicencia, _this.ciudadanosVehiculo[i].fechaPropiedadInicial, _this.ciudadanosVehiculo[i].fechaPropiedadFinal, _this.ciudadanosVehiculo[i].estadoPropiedad);
                    var token_1 = _this._loginService.getToken();
                    _this._CiudadanoVehiculoService.editCiudadanoVehiculo(ciudadanoVehiculo, token_1).subscribe(function (response) {
                        _this.respuesta = response;
                        if (_this.respuesta.status == "success") {
                            _this.tramiteGeneralCreado.emit(true);
                        }
                        (function (error) {
                            _this.errorMessage = error;
                            if (_this.errorMessage != null) {
                                console.log(_this.errorMessage);
                                alert("Error en la petición");
                            }
                        });
                    });
                }
            }
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteGeneralComponent.prototype, "vehiculoId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteGeneralComponent.prototype, "ciudadanoId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteGeneralComponent.prototype, "empresaId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteGeneralComponent.prototype, "Apoderado", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteGeneralComponent.prototype, "tramiteGeneralCreado", void 0);
    NewTramiteGeneralComponent = __decorate([
        core_1.Component({
            selector: 'registerTramiteGeneral',
            templateUrl: 'app/view/tramiteGeneral/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteGeneral_service_1.TramiteGeneralService, vehiculo_service_1.VehiculoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService]
        }), 
        __metadata('design:paramtypes', [tramiteGeneral_service_1.TramiteGeneralService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, router_1.Router])
    ], NewTramiteGeneralComponent);
    return NewTramiteGeneralComponent;
}());
exports.NewTramiteGeneralComponent = NewTramiteGeneralComponent;
//# sourceMappingURL=new.tramiteGeneral.component.js.map
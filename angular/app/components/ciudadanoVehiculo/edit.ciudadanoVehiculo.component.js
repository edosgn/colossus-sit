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
var vehiculo_service_1 = require("../../services/vehiculo/vehiculo.service");
var CiudadanoVehiculo_1 = require('../../model/CiudadanoVehiculo/CiudadanoVehiculo');
var CiudadanoVehiculo_service_1 = require("../../services/CiudadanoVehiculo/CiudadanoVehiculo.service");
var ciudadano_service_1 = require("../../services/ciudadano/ciudadano.service");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var CiudadanoVehiculoEditComponent = (function () {
    function CiudadanoVehiculoEditComponent(_CiudadanoService, _CiudadanoVehiculoService, _VehiculoService, _loginService, _route, _router) {
        this._CiudadanoService = _CiudadanoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    CiudadanoVehiculoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(null, null, null, "", "", "", "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._CiudadanoVehiculoService.showCiudadanoVehiculo(token, this.id).subscribe(function (response) {
            var data = response.data;
            _this.ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(data.id, data.ciudadano.id, data.vehiculo.id, data.licenciaTransito, data.fechaPropiedadInicial, data.fechaPropiedadFinal, data.estadoPropiedad);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VehiculoService.getVehiculo().subscribe(function (response) {
            _this.vehiculos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._CiudadanoService.getCiudadano().subscribe(function (response) {
            _this.ciudadanos = response.data;
            console.log(_this.ciudadanos);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    CiudadanoVehiculoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._CiudadanoVehiculoService.editCiudadanoVehiculo(this.ciudadanoVehiculo, token).subscribe(function (response) {
            _this.respuesta = response;
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    CiudadanoVehiculoEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/ciudadanoVehiculo/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, vehiculo_service_1.VehiculoService, CiudadanoVehiculo_service_1.CiudadanoVehiculoService, ciudadano_service_1.CiudadanoService]
        }), 
        __metadata('design:paramtypes', [ciudadano_service_1.CiudadanoService, CiudadanoVehiculo_service_1.CiudadanoVehiculoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], CiudadanoVehiculoEditComponent);
    return CiudadanoVehiculoEditComponent;
}());
exports.CiudadanoVehiculoEditComponent = CiudadanoVehiculoEditComponent;
//# sourceMappingURL=edit.ciudadanoVehiculo.component.js.map
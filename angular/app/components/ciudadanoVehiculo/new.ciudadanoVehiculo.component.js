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
var Vehiculo_1 = require('../../model/vehiculo/Vehiculo');
var Ciudadano_1 = require('../../model/ciudadano/Ciudadano');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewCiudadanoVehiculoComponent = (function () {
    function NewCiudadanoVehiculoComponent(_CiudadanoService, _CiudadanoVehiculoService, _VehiculoService, _loginService, _route, _router) {
        this._CiudadanoService = _CiudadanoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewCiudadanoVehiculoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.calse = "form-group has-feedback";
        this.msg = "ingrese la placa";
        this.claseSpan = "";
        this.validate = false;
        this.vehiculo = new Vehiculo_1.Vehiculo(null, null, null, null, null, null, null, null, null, "", "", "", "", "", "", "", "", "", "", "", null, null);
        this.ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(null, null, null, null, null, "", "", "");
        this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
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
    NewCiudadanoVehiculoComponent.prototype.onSubmit = function () {
    };
    NewCiudadanoVehiculoComponent.prototype.onKey = function (event) {
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
                _this.claseSpan = "glyphicon glyphicon-remove form-control-feedback";
                _this.calse = "form-group has-error has-feedback";
            }
            else {
                _this.validate = true;
                _this.claseSpan = "glyphicon glyphicon-ok form-control-feedback";
                _this.calse = "form-group has-success has-feedback";
                _this.msg = response.msj;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewCiudadanoVehiculoComponent.prototype.onKeyCiudadano = function (event) {
        var _this = this;
        var token = this._loginService.getToken();
        var values = event.target.value;
        var ciudadano = {
            'numeroIdentificacion': values,
        };
        this._CiudadanoService.showCiudadanoCedula(token, ciudadano).subscribe(function (response) {
            _this.ciudadano = response.data;
            var status = response.status;
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
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewCiudadanoVehiculoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/ciudadanoVehiculo/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, vehiculo_service_1.VehiculoService, CiudadanoVehiculo_service_1.CiudadanoVehiculoService, ciudadano_service_1.CiudadanoService]
        }), 
        __metadata('design:paramtypes', [ciudadano_service_1.CiudadanoService, CiudadanoVehiculo_service_1.CiudadanoVehiculoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewCiudadanoVehiculoComponent);
    return NewCiudadanoVehiculoComponent;
}());
exports.NewCiudadanoVehiculoComponent = NewCiudadanoVehiculoComponent;
//# sourceMappingURL=new.ciudadanoVehiculo.component.js.map
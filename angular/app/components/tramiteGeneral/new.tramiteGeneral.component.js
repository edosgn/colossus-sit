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
// Decorador component, indicamos en que etiqueta se va a cargar la  
var NewTramiteGeneralComponent = (function () {
    function NewTramiteGeneralComponent(_TramiteGeneralService, _VehiculoService, _loginService, _route, _router) {
        this._TramiteGeneralService = _TramiteGeneralService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewTramiteGeneralComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteGeneral = new TramiteGeneral_1.TramiteGeneral(null, null, null, "", "", null, null, null, "");
        var token = this._loginService.getToken();
        this._VehiculoService.getVehiculo().subscribe(function (response) {
            _this.vehiculos = response.data;
            console.log(_this.vehiculos);
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
        this._TramiteGeneralService.register(this.tramiteGeneral, token).subscribe(function (response) {
            _this.respuesta = response;
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
    NewTramiteGeneralComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/tramiteGeneral/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteGeneral_service_1.TramiteGeneralService, vehiculo_service_1.VehiculoService]
        }), 
        __metadata('design:paramtypes', [tramiteGeneral_service_1.TramiteGeneralService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewTramiteGeneralComponent);
    return NewTramiteGeneralComponent;
}());
exports.NewTramiteGeneralComponent = NewTramiteGeneralComponent;
//# sourceMappingURL=new.tramiteGeneral.component.js.map
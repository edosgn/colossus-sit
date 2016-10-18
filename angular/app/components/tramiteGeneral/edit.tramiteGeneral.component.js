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
var TramiteGeneral_1 = require('../../model/tramiteGeneral/TramiteGeneral');
var vehiculo_service_1 = require('../../services/vehiculo/vehiculo.service');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var TramiteGeneralEditComponent = (function () {
    function TramiteGeneralEditComponent(_loginService, _TramiteGeneralService, _VehiculoService, _route, _router) {
        this._loginService = _loginService;
        this._TramiteGeneralService = _TramiteGeneralService;
        this._VehiculoService = _VehiculoService;
        this._route = _route;
        this._router = _router;
    }
    TramiteGeneralEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteGeneral = new TramiteGeneral_1.TramiteGeneral(null, null, null, "", "", null, null, null, "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._TramiteGeneralService.showTramiteGeneral(token, this.id).subscribe(function (response) {
            var data = response.data;
            _this.tramiteGeneral = new TramiteGeneral_1.TramiteGeneral(data.id, data.vehiculo.id, data.numeroQpl, data.fechaInicial, data.fechaFinal, data.valor, data.numeroLicencia, data.numeroSustrato, data.nombre);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
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
    TramiteGeneralEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._TramiteGeneralService.editTramiteGeneral(this.tramiteGeneral, token).subscribe(function (response) {
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
    TramiteGeneralEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/tramiteGeneral/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteGeneral_service_1.TramiteGeneralService, vehiculo_service_1.VehiculoService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, tramiteGeneral_service_1.TramiteGeneralService, vehiculo_service_1.VehiculoService, router_1.ActivatedRoute, router_1.Router])
    ], TramiteGeneralEditComponent);
    return TramiteGeneralEditComponent;
}());
exports.TramiteGeneralEditComponent = TramiteGeneralEditComponent;
//# sourceMappingURL=edit.tramiteGeneral.component.js.map
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
var tipoIdentificacion_service_1 = require('../../services/tipo_Identificacion/tipoIdentificacion.service');
var ciudadano_service_1 = require("../../services/ciudadano/ciudadano.service");
var Ciudadano_1 = require('../../model/ciudadano/Ciudadano');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var CiudadanoEditComponent = (function () {
    function CiudadanoEditComponent(_TipoIdentificacionService, _loginService, _CiudadanoService, _route, _router) {
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._loginService = _loginService;
        this._CiudadanoService = _CiudadanoService;
        this._route = _route;
        this._router = _router;
    }
    CiudadanoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
        var token = this._loginService.getToken();
        this._TipoIdentificacionService.getTipoIdentificacion().subscribe(function (response) {
            _this.tiposIdentificacion = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._CiudadanoService.showCiudadano(token, this.id).subscribe(function (response) {
            var data = response.data;
            console.log(data);
            _this.ciudadano = new Ciudadano_1.Ciudadano(data.id, data.tipoIdentificacion.id, data.numeroIdentificacion, data.nombres, data.apellidos, data.direccion, data.telefono, data.correo);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    CiudadanoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._CiudadanoService.editCiudadano(this.ciudadano, token).subscribe(function (response) {
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
    CiudadanoEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/ciudadano/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, ciudadano_service_1.CiudadanoService, tipoIdentificacion_service_1.TipoIdentificacionService]
        }), 
        __metadata('design:paramtypes', [tipoIdentificacion_service_1.TipoIdentificacionService, login_service_1.LoginService, ciudadano_service_1.CiudadanoService, router_1.ActivatedRoute, router_1.Router])
    ], CiudadanoEditComponent);
    return CiudadanoEditComponent;
}());
exports.CiudadanoEditComponent = CiudadanoEditComponent;
//# sourceMappingURL=edit.ciudadano.component.js.map
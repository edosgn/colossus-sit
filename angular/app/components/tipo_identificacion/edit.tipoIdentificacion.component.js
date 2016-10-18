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
var TipoIdentificacion_1 = require('../../model/tipo_Identificacion/TipoIdentificacion');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var TipoIdentificacionEditComponent = (function () {
    function TipoIdentificacionEditComponent(_loginService, _TipoIdentificacionService, _route, _router) {
        this._loginService = _loginService;
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._route = _route;
        this._router = _router;
    }
    TipoIdentificacionEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tipoIdentificacion = new TipoIdentificacion_1.TipoIdentificacion(null, "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._TipoIdentificacionService.showTipoIdentificacion(token, this.id).subscribe(function (response) {
            _this.tipoIdentificacion = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    TipoIdentificacionEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._TipoIdentificacionService.editTipoIdentificacion(this.tipoIdentificacion, token).subscribe(function (response) {
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
    TipoIdentificacionEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/Tipo_Identificacion/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tipoIdentificacion_service_1.TipoIdentificacionService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, tipoIdentificacion_service_1.TipoIdentificacionService, router_1.ActivatedRoute, router_1.Router])
    ], TipoIdentificacionEditComponent);
    return TipoIdentificacionEditComponent;
}());
exports.TipoIdentificacionEditComponent = TipoIdentificacionEditComponent;
//# sourceMappingURL=edit.tipoidentificacion.component.js.map
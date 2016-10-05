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
var modulo_service_1 = require('../../services/modulo/modulo.service');
var Modulo_1 = require('../../model/modulo/Modulo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var ModuloEditComponent = (function () {
    function ModuloEditComponent(_loginService, _ModuloService, _route, _router) {
        this._loginService = _loginService;
        this._ModuloService = _ModuloService;
        this._route = _route;
        this._router = _router;
    }
    ModuloEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.modulo = new Modulo_1.Modulo(null, "", "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._ModuloService.showModulo(token, this.id).subscribe(function (response) {
            _this.modulo = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    ModuloEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ModuloService.editModulo(this.modulo, token).subscribe(function (response) {
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
    ModuloEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/modulo/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, modulo_service_1.ModuloService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, modulo_service_1.ModuloService, router_1.ActivatedRoute, router_1.Router])
    ], ModuloEditComponent);
    return ModuloEditComponent;
}());
exports.ModuloEditComponent = ModuloEditComponent;
//# sourceMappingURL=edit.modulo.component.js.map
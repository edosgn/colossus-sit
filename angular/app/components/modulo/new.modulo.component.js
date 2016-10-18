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
var modulo_1 = require('../../model/modulo/modulo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewModuloComponent = (function () {
    function NewModuloComponent(_ModuloService, _loginService, _route, _router) {
        this._ModuloService = _ModuloService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewModuloComponent.prototype.ngOnInit = function () {
        this.modulo = new modulo_1.Modulo(null, "", "");
    };
    NewModuloComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ModuloService.register(this.modulo, token).subscribe(function (response) {
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
    NewModuloComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/modulo/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, modulo_service_1.ModuloService]
        }), 
        __metadata('design:paramtypes', [modulo_service_1.ModuloService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewModuloComponent);
    return NewModuloComponent;
}());
exports.NewModuloComponent = NewModuloComponent;
//# sourceMappingURL=new.modulo.component.js.map
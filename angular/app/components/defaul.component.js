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
var login_service_1 = require("../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var usuario_service_1 = require('../services/usuario.service');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var DefaulComponent = (function () {
    function DefaulComponent(_loginService, _UsuarioService, _route, _router) {
        this._loginService = _loginService;
        this._UsuarioService = _UsuarioService;
        this._route = _route;
        this._router = _router;
    }
    DefaulComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        if (token) {
            console.log('logueado');
        }
        else {
            window.location.href = "/login";
        }
        this._UsuarioService.getUsuarios().subscribe(function (response) {
            _this.Usuarios = response.usuarios;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    DefaulComponent.prototype.deleteUsuario = function (id) {
        var _this = this;
        var token = this._loginService.getToken();
        console.log(token);
        this._UsuarioService.deleteUsuario(token, id).subscribe(function (response) {
            var respuesta = response;
            console.log(respuesta);
            _this.ngOnInit();
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    DefaulComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/default.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, usuario_service_1.UsuarioService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, usuario_service_1.UsuarioService, router_1.ActivatedRoute, router_1.Router])
    ], DefaulComponent);
    return DefaulComponent;
}());
exports.DefaulComponent = DefaulComponent;
//# sourceMappingURL=defaul.component.js.map
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
var Usuario_1 = require('../model/Usuario');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var UsuarioEditComponent = (function () {
    function UsuarioEditComponent(_loginService, _UsuarioService, _route, _router) {
        this._loginService = _loginService;
        this._UsuarioService = _UsuarioService;
        this._route = _route;
        this._router = _router;
        this.roles = [
            { value: 'ROLE_ADMIN', display: 'Administrator' },
            { value: 'ROLE_USER', display: 'Usuario' },
        ];
        this.estados = [
            { value: 'Activo', display: 'Activo' },
            { value: 'Inactivo', display: 'Inactivo' },
        ];
    }
    UsuarioEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.usuario = new Usuario_1.Usuario("", "", "", "", "", "", "", "", "", "", "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._UsuarioService.showUsuario(token, this.id).subscribe(function (response) {
            _this.usuario = response;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    UsuarioEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        console.log(token);
        this._UsuarioService.editUsuario(this.usuario, token).subscribe(function (response) {
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
    UsuarioEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/usuario_edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, usuario_service_1.UsuarioService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, usuario_service_1.UsuarioService, router_1.ActivatedRoute, router_1.Router])
    ], UsuarioEditComponent);
    return UsuarioEditComponent;
}());
exports.UsuarioEditComponent = UsuarioEditComponent;
//# sourceMappingURL=usuario.edit.component.js.map
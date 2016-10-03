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
var login_service_1 = require('../services/login.service');
var Usuario_1 = require('../model/Usuario');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var RegisterComponent = (function () {
    function RegisterComponent(_loginService, _route, _router) {
        this._loginService = _loginService;
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
    RegisterComponent.prototype.ngOnInit = function () {
        this.usuario = new Usuario_1.Usuario("", "", "", "", "", "", "", "activo", "", "", "");
    };
    RegisterComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.usuario);
        this._loginService.register(this.usuario).subscribe(function (response) {
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
    RegisterComponent.prototype.callUsuarioEstado = function (value) {
        console.log(value);
        this.usuario.estado = value;
    };
    RegisterComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/usuario_new.html'
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], RegisterComponent);
    return RegisterComponent;
}());
exports.RegisterComponent = RegisterComponent;
//# sourceMappingURL=register.component.js.map
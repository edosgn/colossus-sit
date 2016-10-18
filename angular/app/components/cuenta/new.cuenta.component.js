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
var cuenta_service_1 = require("../../services/cuenta/cuenta.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var banco_service_1 = require('../../services/banco/banco.service');
var cuenta_1 = require('../../model/cuenta/cuenta');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewCuentaComponent = (function () {
    function NewCuentaComponent(_BancoService, _CuentaService, _loginService, _route, _router) {
        this._BancoService = _BancoService;
        this._CuentaService = _CuentaService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewCuentaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.cuenta = new cuenta_1.Cuenta(null, null, null, "");
        this._BancoService.getBanco().subscribe(function (response) {
            _this.bancos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewCuentaComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.cuenta);
        var token = this._loginService.getToken();
        this._CuentaService.register(this.cuenta, token).subscribe(function (response) {
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
    NewCuentaComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/cuenta/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, cuenta_service_1.CuentaService, banco_service_1.BancoService]
        }), 
        __metadata('design:paramtypes', [banco_service_1.BancoService, cuenta_service_1.CuentaService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewCuentaComponent);
    return NewCuentaComponent;
}());
exports.NewCuentaComponent = NewCuentaComponent;
//# sourceMappingURL=new.cuenta.component.js.map
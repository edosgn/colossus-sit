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
var servicio_service_1 = require("../../services/servicio/servicio.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var servicio_1 = require('../../model/servicio/servicio');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewServicioComponent = (function () {
    function NewServicioComponent(_ServicioService, _loginService, _route, _router) {
        this._ServicioService = _ServicioService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewServicioComponent.prototype.ngOnInit = function () {
        this.servicio = new servicio_1.Servicio(null, "", null);
    };
    NewServicioComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.servicio);
        var token = this._loginService.getToken();
        this._ServicioService.register(this.servicio, token).subscribe(function (response) {
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
    NewServicioComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/servicio/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, servicio_service_1.ServicioService]
        }), 
        __metadata('design:paramtypes', [servicio_service_1.ServicioService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewServicioComponent);
    return NewServicioComponent;
}());
exports.NewServicioComponent = NewServicioComponent;
//# sourceMappingURL=new.servicio.component.js.map
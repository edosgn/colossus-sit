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
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexServicioComponent = (function () {
    function IndexServicioComponent(_ServicioService, _loginService, _route, _router) {
        this._ServicioService = _ServicioService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    IndexServicioComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        if (token) {
            console.log('logueado');
        }
        else {
            this._router.navigate(["/login"]);
        }
        this._ServicioService.getServicio().subscribe(function (response) {
            _this.servicios = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexServicioComponent.prototype.deleteServicio = function (id) {
        var _this = this;
        var token = this._loginService.getToken();
        this._ServicioService.deleteServicio(token, id).subscribe(function (response) {
            _this.respuesta = response;
            console.log(_this.respuesta);
            _this.ngOnInit();
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexServicioComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/servicio/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, servicio_service_1.ServicioService]
        }), 
        __metadata('design:paramtypes', [servicio_service_1.ServicioService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexServicioComponent);
    return IndexServicioComponent;
}());
exports.IndexServicioComponent = IndexServicioComponent;
//# sourceMappingURL=index.servicio.component.js.map
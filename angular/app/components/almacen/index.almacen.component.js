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
var almacen_service_1 = require("../../services/almacen/almacen.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexAlmacenComponent = (function () {
    function IndexAlmacenComponent(_AlmacenService, _loginService, _route, _router) {
        this._AlmacenService = _AlmacenService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    IndexAlmacenComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._AlmacenService.getAlmacen().subscribe(function (response) {
            _this.almacenes = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexAlmacenComponent.prototype.deleteAlmacen = function (id) {
        var _this = this;
        var token = this._loginService.getToken();
        this._AlmacenService.deleteAlmacen(token, id).subscribe(function (response) {
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
    IndexAlmacenComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/almacen/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, almacen_service_1.AlmacenService]
        }), 
        __metadata('design:paramtypes', [almacen_service_1.AlmacenService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexAlmacenComponent);
    return IndexAlmacenComponent;
}());
exports.IndexAlmacenComponent = IndexAlmacenComponent;
//# sourceMappingURL=index.almacen.component.js.map
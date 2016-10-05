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
var clase_service_1 = require("../../services/clase/clase.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var clase_1 = require('../../model/clase/clase');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var ClaseEditComponent = (function () {
    function ClaseEditComponent(_loginService, _ClaseService, _route, _router) {
        this._loginService = _loginService;
        this._ClaseService = _ClaseService;
        this._route = _route;
        this._router = _router;
    }
    ClaseEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.clase = new clase_1.Clase(null, "", null);
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._ClaseService.showClase(token, this.id).subscribe(function (response) {
            _this.clase = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    ClaseEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ClaseService.editClase(this.clase, token).subscribe(function (response) {
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
    ClaseEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/clase/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, clase_service_1.ClaseService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, clase_service_1.ClaseService, router_1.ActivatedRoute, router_1.Router])
    ], ClaseEditComponent);
    return ClaseEditComponent;
}());
exports.ClaseEditComponent = ClaseEditComponent;
//# sourceMappingURL=edit.clase.component.js.map
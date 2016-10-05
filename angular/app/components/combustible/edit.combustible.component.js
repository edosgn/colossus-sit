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
var combustible_service_1 = require("../../services/combustible/combustible.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var combustible_1 = require('../../model/combustible/combustible');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var CombustibleEditComponent = (function () {
    function CombustibleEditComponent(_loginService, _CombustibleService, _route, _router) {
        this._loginService = _loginService;
        this._CombustibleService = _CombustibleService;
        this._route = _route;
        this._router = _router;
    }
    CombustibleEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.combustible = new combustible_1.Combustible(null, "", null);
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._CombustibleService.showCombustible(token, this.id).subscribe(function (response) {
            _this.combustible = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    CombustibleEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._CombustibleService.editCombustible(this.combustible, token).subscribe(function (response) {
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
    CombustibleEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/combustible/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, combustible_service_1.CombustibleService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, combustible_service_1.CombustibleService, router_1.ActivatedRoute, router_1.Router])
    ], CombustibleEditComponent);
    return CombustibleEditComponent;
}());
exports.CombustibleEditComponent = CombustibleEditComponent;
//# sourceMappingURL=edit.combustible.component.js.map
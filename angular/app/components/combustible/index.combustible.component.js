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
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexCombustibleComponent = (function () {
    function IndexCombustibleComponent(_CombustibleService, _loginService, _route, _router) {
        this._CombustibleService = _CombustibleService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    IndexCombustibleComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        if (token) {
            console.log('logueado');
        }
        else {
            this._router.navigate(["/login"]);
        }
        this._CombustibleService.getCombustible().subscribe(function (response) {
            _this.combustibles = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexCombustibleComponent.prototype.deleteCombustible = function (id) {
        var _this = this;
        var token = this._loginService.getToken();
        this._CombustibleService.deleteCombustible(token, id).subscribe(function (response) {
            _this.respuesta = response;
            _this.ngOnInit();
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexCombustibleComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/combustible/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, combustible_service_1.CombustibleService]
        }), 
        __metadata('design:paramtypes', [combustible_service_1.CombustibleService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexCombustibleComponent);
    return IndexCombustibleComponent;
}());
exports.IndexCombustibleComponent = IndexCombustibleComponent;
//# sourceMappingURL=index.combustible.component.js.map
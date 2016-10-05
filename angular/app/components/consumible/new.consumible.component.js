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
var login_service_1 = require('../../services/login.service');
var consumible_service_1 = require('../../services/consumible/consumible.service');
var Consumible_1 = require('../../model/consumible/Consumible');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewConsumibleComponent = (function () {
    function NewConsumibleComponent(_ConsumibleService, _loginService, _route, _router) {
        this._ConsumibleService = _ConsumibleService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewConsumibleComponent.prototype.ngOnInit = function () {
        this.consumible = new Consumible_1.Consumible(null, "");
    };
    NewConsumibleComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ConsumibleService.register(this.consumible, token).subscribe(function (response) {
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
    NewConsumibleComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/consumible/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, consumible_service_1.ConsumibleService]
        }), 
        __metadata('design:paramtypes', [consumible_service_1.ConsumibleService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewConsumibleComponent);
    return NewConsumibleComponent;
}());
exports.NewConsumibleComponent = NewConsumibleComponent;
//# sourceMappingURL=new.consumible.component.js.map
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
var carroceria_service_1 = require("../../services/carroceria/carroceria.service");
var clase_service_1 = require("../../services/clase/clase.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var carroceria_1 = require('../../model/carroceria/carroceria');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewCarroceriaComponent = (function () {
    function NewCarroceriaComponent(_ClaseService, _CarroceriaService, _loginService, _route, _router) {
        this._ClaseService = _ClaseService;
        this._CarroceriaService = _CarroceriaService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewCarroceriaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.carroceria = new carroceria_1.Carroceria(null, null, "", null);
        this._ClaseService.getClase().subscribe(function (response) {
            _this.clases = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewCarroceriaComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.carroceria);
        var token = this._loginService.getToken();
        this._CarroceriaService.register(this.carroceria, token).subscribe(function (response) {
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
    NewCarroceriaComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/carroceria/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, carroceria_service_1.CarroceriaService, clase_service_1.ClaseService]
        }), 
        __metadata('design:paramtypes', [clase_service_1.ClaseService, carroceria_service_1.CarroceriaService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewCarroceriaComponent);
    return NewCarroceriaComponent;
}());
exports.NewCarroceriaComponent = NewCarroceriaComponent;
//# sourceMappingURL=new.carroceria.component.js.map
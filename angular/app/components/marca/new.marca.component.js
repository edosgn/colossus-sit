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
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var marca_service_1 = require('../../services/marca/marca.service');
var router_1 = require("@angular/router");
var marca_1 = require('../../model/marca/marca');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewMarcaComponent = (function () {
    function NewMarcaComponent(_MarcaService, _loginService, _route, _router) {
        this._MarcaService = _MarcaService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewMarcaComponent.prototype.ngOnInit = function () {
        this.marca = new marca_1.Marca(null, "", null);
    };
    NewMarcaComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.marca);
        var token = this._loginService.getToken();
        this._MarcaService.register(this.marca, token).subscribe(function (response) {
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
    NewMarcaComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/marca/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, marca_service_1.MarcaService]
        }), 
        __metadata('design:paramtypes', [marca_service_1.MarcaService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewMarcaComponent);
    return NewMarcaComponent;
}());
exports.NewMarcaComponent = NewMarcaComponent;
//# sourceMappingURL=new.marca.component.js.map
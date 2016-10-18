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
var departamento_service_1 = require('../../services/departamento/departamento.service');
var Departamento_1 = require('../../model/departamento/Departamento');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewDepartamentoComponent = (function () {
    function NewDepartamentoComponent(_DepartementoService, _loginService, _route, _router) {
        this._DepartementoService = _DepartementoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewDepartamentoComponent.prototype.ngOnInit = function () {
        this.departamento = new Departamento_1.Departamento(null, "", null);
    };
    NewDepartamentoComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.departamento);
        var token = this._loginService.getToken();
        this._DepartementoService.register(this.departamento, token).subscribe(function (response) {
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
    NewDepartamentoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/departamento/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, departamento_service_1.DepartamentoService]
        }), 
        __metadata('design:paramtypes', [departamento_service_1.DepartamentoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewDepartamentoComponent);
    return NewDepartamentoComponent;
}());
exports.NewDepartamentoComponent = NewDepartamentoComponent;
//# sourceMappingURL=new.departamento.component.js.map
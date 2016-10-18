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
var DepartamentoEditComponent = (function () {
    function DepartamentoEditComponent(_loginService, _DepartamentoService, _route, _router) {
        this._loginService = _loginService;
        this._DepartamentoService = _DepartamentoService;
        this._route = _route;
        this._router = _router;
    }
    DepartamentoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.departamento = new Departamento_1.Departamento(null, "", null);
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._DepartamentoService.showDepartamento(token, this.id).subscribe(function (response) {
            _this.departamento = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    DepartamentoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._DepartamentoService.editDepartamento(this.departamento, token).subscribe(function (response) {
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
    DepartamentoEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/departamento/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, departamento_service_1.DepartamentoService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, departamento_service_1.DepartamentoService, router_1.ActivatedRoute, router_1.Router])
    ], DepartamentoEditComponent);
    return DepartamentoEditComponent;
}());
exports.DepartamentoEditComponent = DepartamentoEditComponent;
//# sourceMappingURL=edit.departamento.component.js.map
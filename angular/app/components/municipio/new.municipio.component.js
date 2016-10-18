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
var municipio_service_1 = require('../../services/municipio/municipio.service');
var Municipio_1 = require('../../model/municipio/Municipio');
var departamento_service_1 = require('../../services/departamento/departamento.service');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewMunicipioComponent = (function () {
    function NewMunicipioComponent(_DepartamentoService, _MunicipioService, _loginService, _route, _router) {
        this._DepartamentoService = _DepartamentoService;
        this._MunicipioService = _MunicipioService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewMunicipioComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.municipio = new Municipio_1.Municipio(null, null, "", null);
        this._DepartamentoService.getDepartamento().subscribe(function (response) {
            _this.departamentos = response.data;
            console.log(_this.departamentos[0].nombre);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewMunicipioComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._MunicipioService.register(this.municipio, token).subscribe(function (response) {
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
    NewMunicipioComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/municipio/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, municipio_service_1.MunicipioService, departamento_service_1.DepartamentoService]
        }), 
        __metadata('design:paramtypes', [departamento_service_1.DepartamentoService, municipio_service_1.MunicipioService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewMunicipioComponent);
    return NewMunicipioComponent;
}());
exports.NewMunicipioComponent = NewMunicipioComponent;
//# sourceMappingURL=new.municipio.component.js.map
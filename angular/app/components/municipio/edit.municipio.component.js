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
var municipio_service_1 = require("../../services/municipio/municipio.service");
var Municipio_1 = require('../../model/municipio/Municipio');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var MunicipioEditComponent = (function () {
    function MunicipioEditComponent(_loginService, _DepartamentoService, _MunicipioService, _route, _router) {
        this._loginService = _loginService;
        this._DepartamentoService = _DepartamentoService;
        this._MunicipioService = _MunicipioService;
        this._route = _route;
        this._router = _router;
    }
    MunicipioEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.municipio = new Municipio_1.Municipio(null, null, "", null);
        var token = this._loginService.getToken();
        this._DepartamentoService.getDepartamento().subscribe(function (response) {
            _this.departamentos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._MunicipioService.showMunicipio(token, this.id).subscribe(function (response) {
            var data = response.data;
            _this.municipio = new Municipio_1.Municipio(data.id, data.departamento.id, data.nombre, data.codigoDian);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    MunicipioEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._MunicipioService.editMunicipio(this.municipio, token).subscribe(function (response) {
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
    MunicipioEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/municipio/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, departamento_service_1.DepartamentoService, municipio_service_1.MunicipioService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, departamento_service_1.DepartamentoService, municipio_service_1.MunicipioService, router_1.ActivatedRoute, router_1.Router])
    ], MunicipioEditComponent);
    return MunicipioEditComponent;
}());
exports.MunicipioEditComponent = MunicipioEditComponent;
//# sourceMappingURL=edit.municipio.component.js.map
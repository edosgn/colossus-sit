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
var tipoEmpresa_service_1 = require("../../services/tipo_Empresa/tipoEmpresa.service");
var ciudadano_service_1 = require("../../services/ciudadano/ciudadano.service");
var municipio_service_1 = require('../../services/municipio/municipio.service');
var departamento_service_1 = require('../../services/departamento/departamento.service');
var empresa_service_1 = require("../../services/empresa/empresa.service");
var Empresa_1 = require('../../model/empresa/Empresa');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewEmpresaComponent = (function () {
    function NewEmpresaComponent(_CiudadanoService, _TipoEmpresaService, _MunicipioService, _DepartamentoService, _EmpresaService, _loginService, _route, _router) {
        this._CiudadanoService = _CiudadanoService;
        this._TipoEmpresaService = _TipoEmpresaService;
        this._MunicipioService = _MunicipioService;
        this._DepartamentoService = _DepartamentoService;
        this._EmpresaService = _EmpresaService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.habilitar = true;
        this.validateCedula = false;
    }
    NewEmpresaComponent.prototype.onChange = function (departamentoValue) {
        var _this = this;
        this.departamento = {
            "departamentoId": departamentoValue,
        };
        var token = this._loginService.getToken();
        this._MunicipioService.getMunicipiosDep(this.departamento, token).subscribe(function (response) {
            _this.municipios = response.data;
            _this.empresa.municipioId = _this.municipios[0].id;
            _this.habilitar = false;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewEmpresaComponent.prototype.onKeyCiudadano = function (event) {
        var _this = this;
        var token = this._loginService.getToken();
        var values = event.target.value;
        var ciudadano = {
            'numeroIdentificacion': values,
        };
        this._CiudadanoService.showCiudadanoCedula(token, ciudadano).subscribe(function (response) {
            _this.ciudadano = response.data;
            var status = response.status;
            if (status == 'error') {
                _this.validateCedula = false;
                _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                _this.calseCedula = "form-group has-error has-feedback";
            }
            else {
                _this.validateCedula = true;
                _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                _this.calseCedula = "form-group has-success has-feedback";
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewEmpresaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.empresa = new Empresa_1.Empresa(null, null, null, null, null, "", "", "", "");
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
        this._TipoEmpresaService.getTipoEmpresa().subscribe(function (response) {
            _this.tiposEmpresa = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewEmpresaComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._EmpresaService.register(this.empresa, token).subscribe(function (response) {
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
    NewEmpresaComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/empresa/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, empresa_service_1.EmpresaService, municipio_service_1.MunicipioService, tipoEmpresa_service_1.TipoEmpresaService, ciudadano_service_1.CiudadanoService, departamento_service_1.DepartamentoService]
        }), 
        __metadata('design:paramtypes', [ciudadano_service_1.CiudadanoService, tipoEmpresa_service_1.TipoEmpresaService, municipio_service_1.MunicipioService, departamento_service_1.DepartamentoService, empresa_service_1.EmpresaService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewEmpresaComponent);
    return NewEmpresaComponent;
}());
exports.NewEmpresaComponent = NewEmpresaComponent;
//# sourceMappingURL=new.empresa.component.js.map
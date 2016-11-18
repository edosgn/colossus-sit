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
var modalidad_service_1 = require('../../services/modalidad/modalidad.service');
var vehiculo_service_1 = require('../../services/vehiculo/vehiculo.service');
var empresa_service_1 = require('../../services/empresa/empresa.service');
var vehiculopesado_service_1 = require("../../services/vehiculopesado/vehiculopesado.service");
var VehiculoPesado_1 = require('../../model/vehiculopesado/VehiculoPesado');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewVehiculoPesadoComponent = (function () {
    function NewVehiculoPesadoComponent(_ModalidadService, _VehiculoService, _EmpresaService, _VehiculoPesadoService, _loginService, _route, _router) {
        this._ModalidadService = _ModalidadService;
        this._VehiculoService = _VehiculoService;
        this._EmpresaService = _EmpresaService;
        this._VehiculoPesadoService = _VehiculoPesadoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewVehiculoPesadoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.vehiculoPesado = new VehiculoPesado_1.VehiculoPesado(null, null, null, null, null, null, null, "", "");
        var token = this._loginService.getToken();
        this._ModalidadService.getModalidad().subscribe(function (response) {
            _this.modalidades = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VehiculoService.getVehiculo().subscribe(function (response) {
            _this.vehiculos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._EmpresaService.getEmpresa().subscribe(function (response) {
            _this.empresas = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewVehiculoPesadoComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._VehiculoPesadoService.register(this.vehiculoPesado, token).subscribe(function (response) {
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
    NewVehiculoPesadoComponent.prototype.onKeyEmpresa = function (event) {
        var _this = this;
        var nit = {
            'nit': event,
        };
        var token = this._loginService.getToken();
        this._EmpresaService.showNit(token, nit).subscribe(function (response) {
            var status = response.status;
            if (status == "error") {
                _this.validateCedula = false;
                _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                _this.claseCedula = "form-group has-error has-feedback ";
                _this.empresa = null;
                _this.divEmpresa = null;
            }
            else {
                _this.divEmpresa = true;
                _this.empresa = response.data;
                _this.validateCedula = true;
                _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                _this.claseCedula = "form-group has-success has-feedback ";
                _this.vehiculoPesado.empresaId = _this.empresa.id;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewVehiculoPesadoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/vehiculopesado/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, vehiculopesado_service_1.VehiculoPesadoService, modalidad_service_1.ModalidadService, vehiculo_service_1.VehiculoService, empresa_service_1.EmpresaService]
        }), 
        __metadata('design:paramtypes', [modalidad_service_1.ModalidadService, vehiculo_service_1.VehiculoService, empresa_service_1.EmpresaService, vehiculopesado_service_1.VehiculoPesadoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewVehiculoPesadoComponent);
    return NewVehiculoPesadoComponent;
}());
exports.NewVehiculoPesadoComponent = NewVehiculoPesadoComponent;
//# sourceMappingURL=new.vehiculoPesado.component.js.map
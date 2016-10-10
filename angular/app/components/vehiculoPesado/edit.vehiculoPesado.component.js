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
var VehiculoPesadoEditComponent = (function () {
    function VehiculoPesadoEditComponent(_ModalidadService, _VehiculoService, _EmpresaService, _VehiculoPesadoService, _loginService, _route, _router) {
        this._ModalidadService = _ModalidadService;
        this._VehiculoService = _VehiculoService;
        this._EmpresaService = _EmpresaService;
        this._VehiculoPesadoService = _VehiculoPesadoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    VehiculoPesadoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.vehiculoPesado = new VehiculoPesado_1.VehiculoPesado(null, null, null, null, null, null, null, "", "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._VehiculoPesadoService.showVehiculoPesado(token, this.id).subscribe(function (response) {
            var data = response.data;
            _this.vehiculoPesado = new VehiculoPesado_1.VehiculoPesado(data.id, data.modalidad.id, data.vehiculo.id, data.empresa.id, data.tonelaje, data.numeroEjes, data.numeroMt, data.fichaTecnicaHomologacionCarroceria, data.fichaTecnicaHomologacionChasis);
            console.log(_this.vehiculoPesado);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
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
    VehiculoPesadoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._VehiculoPesadoService.editVehiculoPesado(this.vehiculoPesado, token).subscribe(function (response) {
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
    VehiculoPesadoEditComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/vehiculopesado/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, vehiculopesado_service_1.VehiculoPesadoService, modalidad_service_1.ModalidadService, vehiculo_service_1.VehiculoService, empresa_service_1.EmpresaService]
        }), 
        __metadata('design:paramtypes', [modalidad_service_1.ModalidadService, vehiculo_service_1.VehiculoService, empresa_service_1.EmpresaService, vehiculopesado_service_1.VehiculoPesadoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], VehiculoPesadoEditComponent);
    return VehiculoPesadoEditComponent;
}());
exports.VehiculoPesadoEditComponent = VehiculoPesadoEditComponent;
//# sourceMappingURL=edit.vehiculoPesado.component.js.map
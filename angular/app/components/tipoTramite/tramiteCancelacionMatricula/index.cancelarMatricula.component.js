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
var login_service_1 = require("../../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var vehiculo_1 = require("../../../model/vehiculo/vehiculo");
var tramiteEspecifico_service_1 = require("../../../services/tramiteEspecifico/tramiteEspecifico.service");
var TramiteEspecifico_1 = require('../../../model/tramiteEspecifico/TramiteEspecifico');
var vehiculo_service_1 = require("../../../services/vehiculo/vehiculo.service");
var variante_service_1 = require("../../../services/variante/variante.service");
var caso_service_1 = require("../../../services/caso/caso.service");
var ciudadanovehiculo_1 = require("../../../model/ciudadanovehiculo/ciudadanovehiculo");
var ciudadanoVehiculo_service_1 = require('../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewTramiteCancelarMatriculaComponent = (function () {
    function NewTramiteCancelarMatriculaComponent(_TramiteEspecificoService, _CiudadanoVehiculoService, _VarianteService, _CasoService, _VehiculoService, _loginService, _route, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._VarianteService = _VarianteService;
        this._CasoService = _CasoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.servicioSeleccionado = null;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.tramiteGeneralId = 33;
        this.ciudadanosVehiculo = null;
        this.vehiculo = null;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'newData': null,
            'oldData': null
        };
        this.cancelado = 0;
    }
    NewTramiteCancelarMatriculaComponent.prototype.ngOnInit = function () {
        var _this = this;
        if (this.ciudadanosVehiculo[0].ciudadano) {
            this.datos.oldData = this.ciudadanosVehiculo[0].ciudadano.numeroIdentificacion;
            this.idCiudadanoOld = this.ciudadanosVehiculo[0].ciudadano.id;
        }
        else {
            this.datos.oldData = this.ciudadanosVehiculo[0].empresa.nit;
            this.nitEmpresaOld = this.ciudadanosVehiculo[0].empresa.nit;
        }
        this.datos.oldData = this.vehiculo.chasis;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 15, this.tramiteGeneralId, null, null, null);
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 15).subscribe(function (response) {
            _this.casos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VarianteService.showVariantesTramite(token, 15).subscribe(function (response) {
            _this.variantes = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewTramiteCancelarMatriculaComponent.prototype.enviarTramite = function () {
        var _this = this;
        for (var i in this.ciudadanosVehiculo) {
            var ciudadanoVehiculo = new ciudadanovehiculo_1.CiudadanoVehiculo(this.ciudadanosVehiculo[i].id, this.idCiudadanoOld, this.ciudadanosVehiculo[i].vehiculo.placa, this.nitEmpresaOld, this.ciudadanosVehiculo[i].licenciaTransito, this.ciudadanosVehiculo[i].fechaPropiedadInicial, this.ciudadanosVehiculo[i].fechaPropiedadFinal, '0');
            var token_1 = this._loginService.getToken();
            this._CiudadanoVehiculoService.editCiudadanoVehiculo(ciudadanoVehiculo, token_1).subscribe(function (response) {
                _this.respuesta = response;
                if (_this.respuesta.status == "success") {
                    _this.tramiteCreado.emit(true);
                }
                (function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
            });
        }
        this.cancelado = 1;
        var token = this._loginService.getToken();
        this._TramiteEspecificoService.register2(this.tramiteEspecifico, token, this.datos).subscribe(function (response) {
            _this.respuesta = response;
            if (_this.respuesta.status == "success") {
                _this.tramiteCreado.emit(true);
            }
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
        this.vehiculo2 = new vehiculo_1.Vehiculo(this.vehiculo.id, this.vehiculo.clase.id, this.vehiculo.municipio.id, this.vehiculo.linea.id, this.vehiculo.servicio.id, this.vehiculo.color.id, this.vehiculo.combustible.id, this.vehiculo.carroceria.id, this.vehiculo.organismoTransito.id, this.vehiculo.placa, this.vehiculo.numeroFactura, this.vehiculo.fechaFactura, this.vehiculo.valor, this.vehiculo.numeroManifiesto, this.vehiculo.fechaManifiesto, this.vehiculo.cilindraje, this.vehiculo.modelo, this.vehiculo.motor, this.vehiculo.chasis, this.vehiculo.serie, this.vehiculo.vin, this.vehiculo.numeroPasajeros, this.vehiculo.pignorado, this.cancelado);
        this._VehiculoService.editVehiculo(this.vehiculo2, token).subscribe(function (response) {
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
    NewTramiteCancelarMatriculaComponent.prototype.onChangeCaso = function (event) {
        this.tramiteEspecifico.casoId = event;
    };
    NewTramiteCancelarMatriculaComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteCancelarMatriculaComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteCancelarMatriculaComponent.prototype, "ciudadanosVehiculo", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteCancelarMatriculaComponent.prototype, "vehiculo", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteCancelarMatriculaComponent.prototype, "tramiteCreado", void 0);
    NewTramiteCancelarMatriculaComponent = __decorate([
        core_1.Component({
            selector: 'tramiteCancelarMatricula',
            templateUrl: 'app/view/tipoTramite/cancelarMatricula/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, vehiculo_service_1.VehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewTramiteCancelarMatriculaComponent);
    return NewTramiteCancelarMatriculaComponent;
}());
exports.NewTramiteCancelarMatriculaComponent = NewTramiteCancelarMatriculaComponent;
//# sourceMappingURL=index.cancelarMatricula.component.js.map
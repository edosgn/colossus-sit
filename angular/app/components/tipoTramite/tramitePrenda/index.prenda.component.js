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
var combustible_service_1 = require("../../../services/combustible/combustible.service");
var tipoIdentificacion_service_1 = require('../../../services/tipo_Identificacion/tipoIdentificacion.service');
var empresa_service_1 = require("../../../services/empresa/empresa.service");
var ciudadano_service_1 = require("../../../services/ciudadano/ciudadano.service");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewTramitePrendaComponent = (function () {
    function NewTramitePrendaComponent(_TramiteEspecificoService, _VarianteService, _TipoIdentificacionService, _CombustibleService, _CasoService, _EmpresaService, _CiudadanoService, _VehiculoService, _loginService, _route, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._VarianteService = _VarianteService;
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._CombustibleService = _CombustibleService;
        this._CasoService = _CasoService;
        this._EmpresaService = _EmpresaService;
        this._CiudadanoService = _CiudadanoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.nuevo = true;
        this.usado = null;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.tramiteGeneralId = 22;
        this.vehiculo = null;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'prendario': null
        };
        this.divDatos = false;
        this.idCiudadano = null;
        this.nitEmpresa = null;
        this.cancelado = null;
        this.pignorado = null;
    }
    NewTramitePrendaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 46, this.tramiteGeneralId, null, null, null);
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 46).subscribe(function (response) {
            _this.casos = response.data;
            if (_this.casos != null) {
                _this.tramiteEspecifico.casoId = _this.casos[0].id;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VarianteService.showVariantesTramite(token, 46).subscribe(function (response) {
            _this.variantes = response.data;
            if (_this.variantes != null) {
                _this.tramiteEspecifico.varianteId = _this.variantes[0].id;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._TipoIdentificacionService.getTipoIdentificacion().subscribe(function (response) {
            _this.tipoIdentificaciones = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewTramitePrendaComponent.prototype.enviarTramite = function () {
        var _this = this;
        this.pignorado = true;
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
        this.vehiculo2 = new vehiculo_1.Vehiculo(this.vehiculo.id, this.vehiculo.clase.id, this.vehiculo.municipio.id, this.vehiculo.linea.id, this.vehiculo.servicio.id, this.vehiculo.color.id, this.vehiculo.combustible.id, this.vehiculo.carroceria.id, this.vehiculo.organismoTransito.id, this.vehiculo.placa, this.vehiculo.numeroFactura, this.vehiculo.fechaFactura, this.vehiculo.valor, this.vehiculo.numeroManifiesto, this.vehiculo.fechaManifiesto, this.vehiculo.cilindraje, this.vehiculo.modelo, this.vehiculo.motor, this.vehiculo.chasis, this.vehiculo.serie, this.vehiculo.vin, this.vehiculo.numeroPasajeros, this.pignorado, this.cancelado);
        console.log(this.vehiculo2);
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
    NewTramitePrendaComponent.prototype.onKeyCiudadano = function (event) {
        var _this = this;
        var identificacion = {
            'numeroIdentificacion': event,
        };
        var token = this._loginService.getToken();
        this._CiudadanoService.showCiudadanoCedula(token, identificacion).subscribe(function (response) {
            var status = response.status;
            if (status == "error") {
                _this.validateCedula = false;
                _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                _this.claseCedula = "form-group has-error has-feedback ";
                _this.ciudadano = null;
            }
            else {
                _this.divCiudadano = true;
                _this.ciudadano = response.data;
                _this.datos.prendario = _this.ciudadano.numeroIdentificacion;
                _this.idCiudadano = _this.ciudadano.id;
                _this.validateCedula = true;
                _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                _this.claseCedula = "form-group has-success has-feedback ";
                _this.empresa = null;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewTramitePrendaComponent.prototype.onKeyEmpresa = function (event) {
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
            }
            else {
                _this.divEmpresa = true;
                _this.empresa = response.data;
                _this.datos.prendario = _this.empresa.nit;
                _this.nitEmpresa = _this.empresa.nit;
                _this.validateCedula = true;
                _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                _this.claseCedula = "form-group has-success has-feedback ";
                _this.ciudadano = null;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewTramitePrendaComponent.prototype.onChangeCaso = function (event) {
        this.tramiteEspecifico.casoId = event;
    };
    NewTramitePrendaComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramitePrendaComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramitePrendaComponent.prototype, "vehiculo", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramitePrendaComponent.prototype, "tramiteCreado", void 0);
    NewTramitePrendaComponent = __decorate([
        core_1.Component({
            selector: 'tramitePrenda',
            templateUrl: 'app/view/tipoTramite/prenda/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, vehiculo_service_1.VehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService, combustible_service_1.CombustibleService, tipoIdentificacion_service_1.TipoIdentificacionService, ciudadano_service_1.CiudadanoService, empresa_service_1.EmpresaService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, tipoIdentificacion_service_1.TipoIdentificacionService, combustible_service_1.CombustibleService, caso_service_1.CasoService, empresa_service_1.EmpresaService, ciudadano_service_1.CiudadanoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewTramitePrendaComponent);
    return NewTramitePrendaComponent;
}());
exports.NewTramitePrendaComponent = NewTramitePrendaComponent;
//# sourceMappingURL=index.prenda.component.js.map
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
var ciudadanovehiculo_1 = require("../../../model/ciudadanovehiculo/ciudadanovehiculo");
var tramiteEspecifico_service_1 = require("../../../services/tramiteEspecifico/tramiteEspecifico.service");
var empresa_service_1 = require("../../../services/empresa/empresa.service");
var ciudadano_service_1 = require("../../../services/ciudadano/ciudadano.service");
var TramiteEspecifico_1 = require('../../../model/tramiteEspecifico/TramiteEspecifico');
var vehiculo_service_1 = require("../../../services/vehiculo/vehiculo.service");
var variante_service_1 = require("../../../services/variante/variante.service");
var caso_service_1 = require("../../../services/caso/caso.service");
var tipoIdentificacion_service_1 = require('../../../services/tipo_Identificacion/tipoIdentificacion.service');
var ciudadanoVehiculo_service_1 = require('../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service');
var Ciudadano_1 = require('../../../model/ciudadano/Ciudadano');
var Empresa_1 = require('../../../model/empresa/Empresa');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewTramiteRematriculaComponent = (function () {
    function NewTramiteRematriculaComponent(_TramiteEspecificoService, _VarianteService, _CiudadanoVehiculoService, _TipoIdentificacionService, _CasoService, _VehiculoService, _loginService, _route, _EmpresaService, _CiudadanoService, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._VarianteService = _VarianteService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._CasoService = _CasoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._EmpresaService = _EmpresaService;
        this._CiudadanoService = _CiudadanoService;
        this._router = _router;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.vehiculo = null;
        this.tramiteGeneralId = null;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'newData': null,
            'oldData': null,
            'datosRematricula': null
        };
        this.divDatos = false;
        this.idCiudadanoOld = null;
        this.nitEmpresaOld = null;
        this.idCiudadanoNew = null;
        this.nitEmpresaNew = null;
        this.TipoMatricula = null;
        this.TipoTramite = null;
        this.json = null;
        this.empresa = new Empresa_1.Empresa(null, null, null, null, null, "", "", "", "");
        this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
        this.ciudadanoVehiculo = new ciudadanovehiculo_1.CiudadanoVehiculo(null, null, null, null, null, "", "", "");
    }
    NewTramiteRematriculaComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 36).subscribe(function (response) {
            _this.casos = response.data;
            if (_this.casos != null) {
                _this.tramiteEspecifico.casoId = _this.casos[0].id;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
        this._VarianteService.showVariantesTramite(token, 36).subscribe(function (response) {
            _this.variantes = response.data;
            if (_this.variantes != null) {
                _this.tramiteEspecifico.varianteId = _this.variantes[0].id;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
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
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 36, this.tramiteGeneralId, null, null, null);
    };
    NewTramiteRematriculaComponent.prototype.enviarTramite = function () {
        var _this = this;
        var ciudadanoVehiculo = new ciudadanovehiculo_1.CiudadanoVehiculo(null, this.idCiudadanoNew, this.vehiculo.placa, this.nitEmpresaNew, this.ciudadanoVehiculo.licenciaTransito, this.ciudadanoVehiculo.fechaPropiedadInicial, this.ciudadanoVehiculo.fechaPropiedadInicial, "1");
        var token = this._loginService.getToken();
        this._CiudadanoVehiculoService.register(ciudadanoVehiculo, token, this.TipoMatricula, this.json, this.TipoTramite).subscribe(function (response) {
            _this.respuesta = response;
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
        this._TramiteEspecificoService.register2(this.tramiteEspecifico, token, this.datos).subscribe(function (response) {
            _this.respuesta = response;
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    alert("Error en la petición");
                }
            });
        });
        this.vehiculo2 = new vehiculo_1.Vehiculo(this.vehiculo.id, this.vehiculo.clase.id, this.vehiculo.municipio.id, this.vehiculo.linea.id, this.vehiculo.servicio.id, this.vehiculo.color.id, this.vehiculo.combustible.id, this.vehiculo.carroceria.id, this.vehiculo.organismoTransito.id, this.vehiculo.placa, this.vehiculo.numeroFactura, this.vehiculo.fechaFactura, this.vehiculo.valor, this.vehiculo.numeroManifiesto, this.vehiculo.fechaManifiesto, this.vehiculo.cilindraje, this.vehiculo.modelo, this.vehiculo.motor, this.vehiculo.chasis, this.vehiculo.serie, this.vehiculo.vin, this.vehiculo.numeroPasajeros, this.vehiculo.pignorado, 0);
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
    NewTramiteRematriculaComponent.prototype.onChangeCaso = function (event) {
        this.datos.datosRematricula = "con opcion de compra";
        for (var i = 0; i < this.casos.length; ++i) {
            if (event == this.casos[i].id) {
                this.casoSeleccionado = this.casos[i];
            }
        }
        if (this.casoSeleccionado.nombre == "LEASING") {
            this.divDatos = true;
        }
        else {
            this.divDatos = false;
        }
        this.tramiteEspecifico.casoId = event;
    };
    NewTramiteRematriculaComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    NewTramiteRematriculaComponent.prototype.onKeyCiudadano = function (event) {
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
                _this.idCiudadanoNew = _this.ciudadano.numeroIdentificacion;
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
    NewTramiteRematriculaComponent.prototype.onKeyEmpresa = function (event) {
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
                _this.nitEmpresaNew = _this.empresa.nit;
                _this.validateCedula = true;
                _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                _this.claseCedula = "form-group has-success has-feedback ";
                _this.ciudadano = null;
                _this.nitEmpresaNew = _this.empresa.nit;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewTramiteRematriculaComponent.prototype.onChangeCasoData = function (event) {
        this.datos.datosRematricula = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteRematriculaComponent.prototype, "vehiculo", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteRematriculaComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteRematriculaComponent.prototype, "tramiteCreado", void 0);
    NewTramiteRematriculaComponent = __decorate([
        core_1.Component({
            selector: 'tramiteRematricula',
            templateUrl: 'app/view/tipoTramite/tramiteRematricula/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, vehiculo_service_1.VehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService, tipoIdentificacion_service_1.TipoIdentificacionService, empresa_service_1.EmpresaService, ciudadano_service_1.CiudadanoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, tipoIdentificacion_service_1.TipoIdentificacionService, caso_service_1.CasoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, empresa_service_1.EmpresaService, ciudadano_service_1.CiudadanoService, router_1.Router])
    ], NewTramiteRematriculaComponent);
    return NewTramiteRematriculaComponent;
}());
exports.NewTramiteRematriculaComponent = NewTramiteRematriculaComponent;
//# sourceMappingURL=index.rematricula.component.js.map
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
var NewTramiteTraspasoComponent = (function () {
    function NewTramiteTraspasoComponent(_TramiteEspecificoService, _VarianteService, _CiudadanoVehiculoService, _TipoIdentificacionService, _CasoService, _VehiculoService, _loginService, _route, _EmpresaService, _CiudadanoService, _router) {
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
        this.colorSeleccionado = null;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.ciudadanosVehiculo = null;
        this.tramiteGeneralId = null;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'newPropietario': null,
            'oldPropietario': null,
            'datosCasos': null
        };
        this.divDatos = false;
        this.idCiudadanoOld = null;
        this.nitEmpresaOld = null;
        this.idCiudadanoNew = null;
        this.nitEmpresaNew = null;
        this.empresa = new Empresa_1.Empresa(null, null, null, null, null, "", "", "", "");
        this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
    }
    NewTramiteTraspasoComponent.prototype.ngOnInit = function () {
        var _this = this;
        if (this.ciudadanosVehiculo[0].ciudadano) {
            this.datos.oldPropietario = this.ciudadanosVehiculo[0].ciudadano.numeroIdentificacion;
            this.idCiudadanoOld = this.ciudadanosVehiculo[0].ciudadano.id;
        }
        else {
            this.datos.oldPropietario = this.ciudadanosVehiculo[0].empresa.nit;
            this.nitEmpresaOld = this.ciudadanosVehiculo[0].empresa.nit;
        }
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 2).subscribe(function (response) {
            _this.casos = response.data;
            _this.tramiteEspecifico.casoId = _this.casos[0].id;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
        this._VarianteService.showVariantesTramite(token, 2).subscribe(function (response) {
            _this.variantes = response.data;
            _this.tramiteEspecifico.varianteId = _this.variantes[0].id;
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
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 2, this.tramiteGeneralId, null, null, null);
        console.log(this.datos);
    };
    NewTramiteTraspasoComponent.prototype.enviarTramite = function () {
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
        var token = this._loginService.getToken();
        this.ciudadanoVehiculoRegister = new ciudadanovehiculo_1.CiudadanoVehiculo(this.ciudadanosVehiculo[i].id, this.idCiudadanoNew, this.ciudadanosVehiculo[i].vehiculo.placa, this.nitEmpresaNew, this.ciudadanosVehiculo[i].licenciaTransito, this.ciudadanosVehiculo[i].fechaPropiedadInicial, this.ciudadanosVehiculo[i].fechaPropiedadFinal, '1');
        console.log(this.ciudadanoVehiculoRegister);
        this._CiudadanoVehiculoService.registerPropietario(this.ciudadanoVehiculoRegister, token).subscribe(function (response) {
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
    };
    NewTramiteTraspasoComponent.prototype.onChangeCaso = function (event) {
        this.datos.datosCasos = "con opcion de compra";
        for (var i = 0; i < this.casos.length; ++i) {
            if (event == this.casos[i].id) {
                this.casoSeleccionado = this.casos[i];
            }
        }
        if (this.casoSeleccionado.nombre == "Leasing") {
            this.divDatos = true;
        }
        else {
            this.divDatos = false;
        }
        this.tramiteEspecifico.casoId = event;
    };
    NewTramiteTraspasoComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    NewTramiteTraspasoComponent.prototype.onKeyCiudadano = function (event) {
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
                _this.idCiudadanoNew = _this.ciudadano.id;
                _this.validateCedula = true;
                _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                _this.claseCedula = "form-group has-success has-feedback ";
                _this.empresa = null;
                _this.datos.newPropietario = _this.ciudadano.numeroIdentificacion;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewTramiteTraspasoComponent.prototype.onKeyEmpresa = function (event) {
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
                _this.datos.newPropietario = _this.empresa.nit;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                alert("Error en la petición");
            }
        });
    };
    NewTramiteTraspasoComponent.prototype.onChangeCasoData = function (event) {
        this.datos.datosCasos = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteTraspasoComponent.prototype, "ciudadanosVehiculo", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteTraspasoComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteTraspasoComponent.prototype, "tramiteCreado", void 0);
    NewTramiteTraspasoComponent = __decorate([
        core_1.Component({
            selector: 'tramiteTraspaso',
            templateUrl: 'app/view/tipoTramite/tramiteTraspaso/index.component.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, vehiculo_service_1.VehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService, tipoIdentificacion_service_1.TipoIdentificacionService, empresa_service_1.EmpresaService, ciudadano_service_1.CiudadanoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, tipoIdentificacion_service_1.TipoIdentificacionService, caso_service_1.CasoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, empresa_service_1.EmpresaService, ciudadano_service_1.CiudadanoService, router_1.Router])
    ], NewTramiteTraspasoComponent);
    return NewTramiteTraspasoComponent;
}());
exports.NewTramiteTraspasoComponent = NewTramiteTraspasoComponent;
//# sourceMappingURL=index.traspaso.component.js.map
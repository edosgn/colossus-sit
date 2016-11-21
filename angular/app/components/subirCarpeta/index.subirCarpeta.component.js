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
var tramite_service_1 = require("../../services/tramite/tramite.service");
var organismoTransito_service_1 = require("../../services/organismoTransito/organismoTransito.service");
var empresa_service_1 = require("../../services/empresa/empresa.service");
var ciudadanoVehiculo_service_1 = require("../../services/ciudadanoVehiculo/ciudadanoVehiculo.service");
var tipoIdentificacion_service_1 = require('../../services/tipo_Identificacion/tipoIdentificacion.service');
var vehiculo_service_1 = require("../../services/vehiculo/vehiculo.service");
var ciudadano_service_1 = require("../../services/ciudadano/ciudadano.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var new_vehiculo_component_1 = require('../../components/vehiculo/new.vehiculo.component');
var new_tramiteGeneral_component_1 = require('../../components/tramiteGeneral/new.tramiteGeneral.component');
var new_ciudadano_component_1 = require('../../components/ciudadano/new.ciudadano.component');
var new_empresa_component_1 = require('../../components/empresa/new.empresa.component');
var CiudadanoVehiculo_1 = require('../../model/CiudadanoVehiculo/CiudadanoVehiculo');
var Ciudadano_1 = require('../../model/ciudadano/Ciudadano');
var tramiteGeneral_service_1 = require('../../services/tramiteGeneral/tramiteGeneral.service');
var vehiculoPesado_service_1 = require('../../services/vehiculoPesado/vehiculoPesado.service');
var tramiteEspecifico_service_1 = require("../../services/tramiteEspecifico/tramiteEspecifico.service");
var Empresa_1 = require('../../model/empresa/Empresa');
var index_traspaso_component_1 = require("../../components/tipoTramite/tramiteTraspaso/index.traspaso.component");
var index_TrasladoCuenta_component_1 = require("../../components/tipoTramite/tramiteTrasladoCuenta/index.TrasladoCuenta.component");
var index_cambioServicio_component_1 = require("../../components/tipoTramite/tramiteCambioServicio/index.cambioServicio.component");
var index_cambioMotor_component_1 = require("../../components/tipoTramite/tramiteCambioMotor/index.cambioMotor.component");
var index_regrabarChasis_component_1 = require("../../components/tipoTramite/tramiteRegrabarChasis/index.regrabarChasis.component");
var index_regrabarSerie_component_1 = require("../../components/tipoTramite/tramiteRegrabarSerie/index.regrabarSerie.component");
var index_cambioColor_component_1 = require("../../components/tipoTramite/tramiteCambioColor/index.cambioColor.component");
var index_cambioCarroceria_component_1 = require("../../components/tipoTramite/tramiteCambioCarroceria/index.cambioCarroceria.component");
var index_duplicadoLicencia_component_1 = require("../../components/tipoTramite/tramiteDuplicadoLicencia/index.duplicadoLicencia.component");
var index_duplicadoPlaca_component_1 = require("../../components/tipoTramite/tramiteDuplicadoPlaca/index.duplicadoPlaca.component");
var index_cambioBlindaje_component_1 = require("../../components/tipoTramite/tramiteCambioBlindaje/index.cambioBlindaje.component");
var index_CambioCombustible_component_1 = require("../../components/tipoTramite/tramiteCambioCombustible/index.CambioCombustible.component");
var index_Prenda_component_1 = require("../../components/tipoTramite/tramitePrenda/index.Prenda.component");
var index_LevantarPrenda_component_1 = require("../../components/tipoTramite/tramiteLevantarPrenda/index.LevantarPrenda.component");
var index_CambioPrendario_component_1 = require("../../components/tipoTramite/tramiteCambioPrendario/index.CambioPrendario.component");
var index_CancelarMatricula_component_1 = require("../../components/tipoTramite/tramiteCancelacionMatricula/index.CancelarMatricula.component");
var index_Rematricula_component_1 = require("../../components/tipoTramite/tramiteRematricula/index.Rematricula.component");
var index_regrabarMotor_component_1 = require("../../components/tipoTramite/tramiteRegrabarMotor/index.regrabarMotor.component");
var new_vehiculoPesado_component_1 = require("../../components/vehiculoPesado/new.vehiculoPesado.component");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexSubirCarpetaComponent = (function () {
    function IndexSubirCarpetaComponent(_TramiteService, _VehiculoPesadoService, _OrganismoTransitoService, _TramiteEspecificoService, _TramiteGeneral, _EmpresaService, _TipoIdentificacionService, _VehiculoService, _CiudadanoService, _CiudadanoVehiculoService, _loginService, _route, _router) {
        var _this = this;
        this._TramiteService = _TramiteService;
        this._VehiculoPesadoService = _VehiculoPesadoService;
        this._OrganismoTransitoService = _OrganismoTransitoService;
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._TramiteGeneral = _TramiteGeneral;
        this._EmpresaService = _EmpresaService;
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._VehiculoService = _VehiculoService;
        this._CiudadanoService = _CiudadanoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.TipoMatricula = 1;
        this.modalVehiculoPesado = false;
        this.TipoTramite = {
            'caso': null,
            'variante': null
        };
        this.vehiculoPesado = null;
        this.vehiculoId = null;
        this.json = {
            'datosGenerales': null,
        };
        this.tablaPesado = false;
        this.divVehiculo = 'panel panel-primary';
        var token = this._loginService.getToken();
        this._TramiteService.TramitesModulo(1, token).subscribe(function (response) {
            _this.tramites = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
        this.ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(null, null, null, null, null, "", "", "");
        this.empresa = new Empresa_1.Empresa(null, null, null, null, null, "", "", "", "");
        this._TipoIdentificacionService.getTipoIdentificacion().subscribe(function (response) {
            _this.tipoIdentificaciones = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._OrganismoTransitoService.getOrganismoTransito().subscribe(function (response) {
            _this.organismoTransitos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    }
    IndexSubirCarpetaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.placa = {
            'placa': this.placa,
        };
        this._route.params.subscribe(function (params) {
            _this.tramiteId = +params["tramiteId"];
        });
        var token = this._loginService.getToken();
    };
    IndexSubirCarpetaComponent.prototype.onKey = function (event) {
        var _this = this;
        this.tramiteEspesificolSeleccionado = null;
        this.idCiudadanoSeleccionado = null;
        var token = this._loginService.getToken();
        this._VehiculoService.showVehiculoPlaca(token, this.placa).subscribe(function (response) {
            _this.vehiculo = response.data;
            if (_this.vehiculo != null) {
                _this.vehiculoId = response.data.id;
                _this.modalVehiculoPesado = true;
                _this._VehiculoPesadoService.showVehiculoPesadoVehiculoId(token, _this.vehiculoId).subscribe(function (response) {
                    _this.vehiculoPesado = response.data;
                    console.log(_this.vehiculoPesado);
                    _this.tablaPesado = true;
                }, function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
            }
            if (_this.vehiculo) {
                if (_this.vehiculo.cancelado == 1 || _this.vehiculo.pignorado == 1) {
                    _this.divVehiculo = 'panel panel-danger';
                }
                else {
                    _this.divVehiculo = 'panel panel-primary';
                }
            }
            var status = response.status;
            if (status == 'error') {
                _this.tramitesGeneral = false;
                _this.validate = false;
                _this.validateCiudadano = false;
                _this.crear = true;
                _this.tramitesGeneralSeccion = false;
                _this.claseSpan = "glyphicon glyphicon-remove form-control-feedback ";
                _this.clase = "form-group has-error has-feedback";
                _this.activar = false;
            }
            else {
                _this.modalVehiculoPesado = true;
                _this.claseSpan = "glyphicon glyphicon-ok form-control-feedback ";
                _this.clase = "form-group has-success has-feedback";
                _this.msg = response.msj;
                _this.crear = false;
                _this.validate = true;
                _this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token, _this.vehiculo.id).subscribe(function (response) {
                    _this.ciudadanosVehiculo = response.data;
                    _this.respuesta = response;
                    _this.tramitesGeneralSeccion = true;
                    if (_this.respuesta.status == 'error') {
                        _this.activar = true;
                        _this.validateCiudadano = false;
                    }
                    else {
                        _this.activar = true;
                        _this.validate = true;
                        _this.validateCiudadano = true;
                    }
                }, function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
                var vehiculoTramite = {
                    'vehiculoId': _this.vehiculo.id,
                };
                _this._TramiteGeneral.showTramiteGeneralVehiculo(token, vehiculoTramite).subscribe(function (response) {
                    _this.tramitesGeneral = response.data;
                    _this.tramiteEspecificos = null;
                }, function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onKeyCiudadano = function (event) {
        var _this = this;
        var identificacion = {
            'numeroIdentificacion': event,
        };
        var token = this._loginService.getToken();
        this._CiudadanoService.showCiudadanoCedula(token, identificacion).subscribe(function (response) {
            var status = response.status;
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].ciudadano) {
                        if (_this.ciudadanosVehiculo[i].ciudadano.numeroIdentificacion == event) {
                            _this.existe = true;
                        }
                    }
                }
            }
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].empresa) {
                        _this.existeEmpresa = true;
                    }
                }
            }
            if (_this.existeEmpresa) {
                _this.validateCedula = false;
                _this.existe = false;
                alert("existe una relacion con una empresa imposible asociar ciudadano");
                return (0);
            }
            if (_this.existe) {
                _this.validateCedula = false;
                _this.existe = false;
                alert("existe una relacion con el ciudadano");
            }
            else {
                if (status == 'error') {
                    _this.validateCedula = false;
                    _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                    _this.calseCedula = "form-group has-error has-feedback ";
                    _this.btnNewPropietario = true;
                    _this.modalCiudadano = true;
                }
                else {
                    _this.ciudadano = response.data;
                    _this.btnNewPropietario = false;
                    _this.validateCedula = true;
                    _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                    _this.calseCedula = "form-group has-success has-feedback ";
                    _this.msgCiudadano = response.msj;
                    _this.divEmpresa = false;
                }
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onKeyEmpresa = function (event) {
        var _this = this;
        var nit = {
            'nit': event,
        };
        var token = this._loginService.getToken();
        this._EmpresaService.showNit(token, nit).subscribe(function (response) {
            var status = response.status;
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].empresa) {
                        if (_this.ciudadanosVehiculo[i].empresa.nit == event) {
                            _this.existe = true;
                        }
                    }
                }
            }
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].ciudadano) {
                        _this.existeCiudadano = true;
                    }
                }
            }
            if (_this.existeCiudadano) {
                _this.validateCedula = false;
                _this.existe = false;
                alert("existe una relacion con un siudadano imposible asociar empresa");
                return (0);
            }
            if (_this.existe) {
                _this.validateCedula = false;
                _this.existe = false;
                alert("existe una relacion con la empresa");
            }
            else {
                if (status == 'error') {
                    _this.validateCedula = false;
                    _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                    _this.calseCedula = "form-group has-error has-feedback ";
                    _this.btnNewPropietario = true;
                    _this.modalEmpresa = true;
                }
                else {
                    _this.empresa = response.data;
                    _this.btnNewPropietario = false;
                    _this.divEmpresa = true;
                    _this.validateCedula = true;
                    _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                    _this.calseCedula = "form-group has-success has-feedback ";
                    _this.msgCiudadano = response.msj;
                    _this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
                }
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.VehiculoCiudadano = function () {
        var _this = this;
        this.ciudadanoVehiculo.ciudadanoId = this.ciudadano.numeroIdentificacion;
        this.ciudadanoVehiculo.estadoPropiedad = "1";
        this.ciudadanoVehiculo.empresaId = this.empresa.nit;
        this.ciudadanoVehiculo.vehiculoId = this.vehiculo.placa;
        this.ciudadanoVehiculo.fechaPropiedadInicial = this.vehiculo.fechaFactura;
        if (this.ciudadanosVehiculo != null) {
            this.ciudadanoVehiculo.licenciaTransito = this.ciudadanosVehiculo[0].licenciaTransito;
        }
        var token = this._loginService.getToken();
        this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo, token, this.TipoMatricula, this.json, this.TipoTramite).subscribe(function (response) {
            _this.respuesta = response;
            if (_this.respuesta.status == 'success') {
                _this.ciudadanoVehiculo.licenciaTransito = null;
                _this.validateCedula = false;
                _this.json = null;
                _this.TipoTramite = null;
                _this.onKey("");
            }
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    IndexSubirCarpetaComponent.prototype.onChangeTramiteGeneral = function (id) {
        var _this = this;
        this.tramiteGeneralSeleccionado = id;
        if (this.vehiculo.cancelado == 0 && this.vehiculo.pignorado == 0) {
            this.tramiteEspesificolSeleccionado = id;
        }
        var token = this._loginService.getToken();
        this._TramiteEspecificoService.showTramiteEspecificoGeneral(token, id).subscribe(function (response) {
            _this.tramiteEspecificos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onChangeApoderado = function (event) {
        if (event == true) {
            this.btnSeleccionarApoderado = true;
        }
        else {
            this.btnSeleccionarApoderado = false;
        }
    };
    IndexSubirCarpetaComponent.prototype.onChangeCiudadano = function (id) {
        this.divTramiteGeneral = false;
        this.idCiudadanoSeleccionado = id;
        this.idEmpresaSeleccionada = null;
    };
    IndexSubirCarpetaComponent.prototype.onChangeEmpresa = function (id) {
        this.divTramiteGeneral = false;
        this.idEmpresaSeleccionada = id;
        this.idCiudadanoSeleccionado = null;
    };
    IndexSubirCarpetaComponent.prototype.onChangeNit = function (Value) {
        if (Value == 4) {
            this.nit = true;
            this.validateCedula = false;
        }
        else {
            this.nit = false;
            this.validateCedula = false;
        }
    };
    IndexSubirCarpetaComponent.prototype.onChangeTipoMatricula = function (event) {
        this.TipoMatricula = event;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarVinculo = function () {
        this.validateCedula = false;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarModalCedula = function () {
        this.modalCiudadano = false;
        this.btnNewPropietario = false;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarModalEmpresa = function () {
        this.modalEmpresa = false;
        this.btnNewPropietario = false;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarModalVehiculoPesado = function () {
        this.modalVehiculoPesado = false;
        this.onKey("");
    };
    IndexSubirCarpetaComponent.prototype.btnNuevoTramiteGeneral = function () {
        if (this.idCiudadanoSeleccionado != null || this.idEmpresaSeleccionada != null) {
            this.divTramiteGeneral = true;
        }
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarNuevoTramiteGeneral = function () {
        this.divTramiteGeneral = false;
    };
    IndexSubirCarpetaComponent.prototype.btnNuevoTramiteEspesifico = function () {
        this.divTramite = true;
    };
    IndexSubirCarpetaComponent.prototype.prueba = function (event) {
        this.json.datosGenerales = event;
    };
    IndexSubirCarpetaComponent.prototype.vheiculoCreado = function (event) {
        this.placa.placa = event;
        this.onKey("");
    };
    IndexSubirCarpetaComponent.prototype.tramiteGeneralCreado = function (tramiteGeneral) {
        if (tramiteGeneral) {
            this.divTramiteGeneral = false;
            this.idCiudadanoSeleccionado = null;
            this.idEmpresaSeleccionada = null;
            this.tramiteGeneralSeccion = null;
            this.onKey("");
        }
    };
    IndexSubirCarpetaComponent.prototype.ciudadanoCreado = function (event) {
        this.onKeyCiudadano(event);
    };
    IndexSubirCarpetaComponent.prototype.empresaCreada = function (event) {
        this.onKeyEmpresa(event);
    };
    IndexSubirCarpetaComponent.prototype.tramiteCreado = function (isCreado) {
        if (isCreado) {
            this.divTramite = false;
            this.onKey("");
        }
    };
    IndexSubirCarpetaComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/subirCarpeta/index.component.html',
            directives: [
                router_1.ROUTER_DIRECTIVES,
                new_vehiculo_component_1.NewVehiculoComponent,
                new_ciudadano_component_1.NewCiudadanoComponent,
                new_empresa_component_1.NewEmpresaComponent,
                new_tramiteGeneral_component_1.NewTramiteGeneralComponent,
                index_traspaso_component_1.NewTramiteTraspasoComponent,
                index_cambioColor_component_1.NewTramiteCambioColorComponent,
                index_cambioServicio_component_1.NewTramiteCambioServicioComponent,
                index_regrabarMotor_component_1.NewTramiteRegrabarMotorComponent,
                index_regrabarChasis_component_1.NewTramiteRegrabarChasisComponent,
                index_regrabarSerie_component_1.NewTramiteRegrabarSerieComponent,
                index_duplicadoLicencia_component_1.NewTramiteDuplicadoLicenciaComponent,
                index_cambioBlindaje_component_1.NewTramiteCambioBlindajeComponent,
                index_cambioMotor_component_1.NewTramiteCambioMotorComponent,
                index_duplicadoPlaca_component_1.NewTramiteDuplicadoPlacaComponent,
                index_cambioCarroceria_component_1.NewTramiteCambioCarroceriaComponent,
                index_TrasladoCuenta_component_1.NewTramiteTrasladoCuentaComponent,
                index_CambioCombustible_component_1.NewTramiteCambioCombustibleComponent,
                index_Prenda_component_1.NewTramitePrendaComponent,
                index_LevantarPrenda_component_1.NewTramiteLevantarPrendaComponent,
                index_CambioPrendario_component_1.NewTramiteCambioPrendarioComponent,
                index_CancelarMatricula_component_1.NewTramiteCancelarMatriculaComponent,
                index_Rematricula_component_1.NewTramiteRematriculaComponent,
                index_regrabarMotor_component_1.NewTramiteRegrabarMotorComponent,
                new_vehiculoPesado_component_1.NewVehiculoPesadoComponent,
            ],
            providers: [
                login_service_1.LoginService,
                tramite_service_1.TramiteService,
                tramiteEspecifico_service_1.TramiteEspecificoService,
                tramiteGeneral_service_1.TramiteGeneralService,
                vehiculo_service_1.VehiculoService,
                ciudadanoVehiculo_service_1.CiudadanoVehiculoService,
                ciudadano_service_1.CiudadanoService,
                tipoIdentificacion_service_1.TipoIdentificacionService,
                empresa_service_1.EmpresaService,
                vehiculoPesado_service_1.VehiculoPesadoService,
                organismoTransito_service_1.OrganismoTransitoService]
        }), 
        __metadata('design:paramtypes', [tramite_service_1.TramiteService, vehiculoPesado_service_1.VehiculoPesadoService, organismoTransito_service_1.OrganismoTransitoService, tramiteEspecifico_service_1.TramiteEspecificoService, tramiteGeneral_service_1.TramiteGeneralService, empresa_service_1.EmpresaService, tipoIdentificacion_service_1.TipoIdentificacionService, vehiculo_service_1.VehiculoService, ciudadano_service_1.CiudadanoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexSubirCarpetaComponent);
    return IndexSubirCarpetaComponent;
}());
exports.IndexSubirCarpetaComponent = IndexSubirCarpetaComponent;
//# sourceMappingURL=index.subirCarpeta.component.js.map
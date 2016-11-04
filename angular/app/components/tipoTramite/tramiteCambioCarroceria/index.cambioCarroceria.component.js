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
var carroceria_service_1 = require('../../../services/carroceria/carroceria.service');
var vehiculo_service_1 = require("../../../services/vehiculo/vehiculo.service");
var variante_service_1 = require("../../../services/variante/variante.service");
var caso_service_1 = require("../../../services/caso/caso.service");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewTramiteCambioCarroceriaComponent = (function () {
    function NewTramiteCambioCarroceriaComponent(_TramiteEspecificoService, _VarianteService, _CarroceriaService, _CasoService, _VehiculoService, _loginService, _route, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._VarianteService = _VarianteService;
        this._CarroceriaService = _CarroceriaService;
        this._CasoService = _CasoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.carroceriaSeleccionada = null;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.tramiteGeneralId = 22;
        this.vehiculo = null;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'newData': null,
            'oldData': null
        };
    }
    NewTramiteCambioCarroceriaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.datos.oldData = this.vehiculo.carroceria.nombre;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 32, this.tramiteGeneralId, null, null, null);
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 32).subscribe(function (response) {
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
        this._VarianteService.showVariantesTramite(token, 32).subscribe(function (response) {
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
        this._CarroceriaService.getCarroceriasClase(this.vehiculo.clase.id, token).subscribe(function (response) {
            _this.carrocerias = response.data;
            _this.datos.newData = _this.carrocerias[0].nombre;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewTramiteCambioCarroceriaComponent.prototype.enviarTramite = function () {
        var _this = this;
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
        this.vehiculo2 = new vehiculo_1.Vehiculo(this.vehiculo.id, this.vehiculo.clase.id, this.vehiculo.municipio.id, this.vehiculo.linea.id, this.vehiculo.servicio.id, this.vehiculo.color.id, this.vehiculo.combustible.id, this.carroceriaSeleccionada.id, this.vehiculo.organismoTransito.id, this.vehiculo.placa, this.vehiculo.numeroFactura, this.vehiculo.fechaFactura, this.vehiculo.valor, this.vehiculo.numeroManifiesto, this.vehiculo.fechaManifiesto, this.vehiculo.cilindraje, this.vehiculo.modelo, this.vehiculo.motor, this.vehiculo.chasis, this.vehiculo.serie, this.vehiculo.vin, this.vehiculo.numeroPasajeros, this.vehiculo.pignorado, this.vehiculo.cancelado);
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
    NewTramiteCambioCarroceriaComponent.prototype.onChangeCarroceria = function (event) {
        for (var i = 0; i < this.carrocerias.length; ++i) {
            if (event == this.carrocerias[i].id) {
                this.carroceriaSeleccionada = this.carrocerias[i];
                this.datos.newData = this.carroceriaSeleccionada.nombre;
            }
        }
    };
    NewTramiteCambioCarroceriaComponent.prototype.onChangeCaso = function (event) {
        this.tramiteEspecifico.casoId = event;
    };
    NewTramiteCambioCarroceriaComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteCambioCarroceriaComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteCambioCarroceriaComponent.prototype, "vehiculo", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteCambioCarroceriaComponent.prototype, "tramiteCreado", void 0);
    NewTramiteCambioCarroceriaComponent = __decorate([
        core_1.Component({
            selector: 'tramiteCambioCarroceria',
            templateUrl: 'app/view/tipoTramite/cambioCarroceria/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, vehiculo_service_1.VehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService, carroceria_service_1.CarroceriaService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, carroceria_service_1.CarroceriaService, caso_service_1.CasoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewTramiteCambioCarroceriaComponent);
    return NewTramiteCambioCarroceriaComponent;
}());
exports.NewTramiteCambioCarroceriaComponent = NewTramiteCambioCarroceriaComponent;
//# sourceMappingURL=index.cambioCarroceria.component.js.map
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
var tramiteEspecifico_service_1 = require("../../../services/tramiteEspecifico/tramiteEspecifico.service");
var TramiteEspecifico_1 = require('../../../model/tramiteEspecifico/TramiteEspecifico');
var variante_service_1 = require("../../../services/variante/variante.service");
var caso_service_1 = require("../../../services/caso/caso.service");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewTramiteDuplicadoLicenciaComponent = (function () {
    function NewTramiteDuplicadoLicenciaComponent(_TramiteEspecificoService, _VarianteService, _CasoService, _loginService, _route, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._VarianteService = _VarianteService;
        this._CasoService = _CasoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.servicioSeleccionado = null;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.tramiteGeneralId = 22;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'newData': null,
            'oldData': null
        };
    }
    NewTramiteDuplicadoLicenciaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 12, this.tramiteGeneralId, null, null, null);
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 12).subscribe(function (response) {
            _this.casos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VarianteService.showVariantesTramite(token, 12).subscribe(function (response) {
            _this.variantes = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewTramiteDuplicadoLicenciaComponent.prototype.enviarTramite = function () {
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
    };
    NewTramiteDuplicadoLicenciaComponent.prototype.onChangeCaso = function (event) {
        this.tramiteEspecifico.casoId = event;
    };
    NewTramiteDuplicadoLicenciaComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteDuplicadoLicenciaComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteDuplicadoLicenciaComponent.prototype, "tramiteCreado", void 0);
    NewTramiteDuplicadoLicenciaComponent = __decorate([
        core_1.Component({
            selector: 'tramiteDuplicadoLicencia',
            templateUrl: 'app/view/tipoTramite/duplicadoLicencia/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, caso_service_1.CasoService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, caso_service_1.CasoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewTramiteDuplicadoLicenciaComponent);
    return NewTramiteDuplicadoLicenciaComponent;
}());
exports.NewTramiteDuplicadoLicenciaComponent = NewTramiteDuplicadoLicenciaComponent;
//# sourceMappingURL=index.duplicadoLicencia.component.js.map
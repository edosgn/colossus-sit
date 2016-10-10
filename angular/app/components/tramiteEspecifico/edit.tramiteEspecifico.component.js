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
var tramiteEspecifico_service_1 = require('../../services/tramiteEspecifico/tramiteEspecifico.service');
var tramiteGeneral_service_1 = require('../../services/tramiteGeneral/tramiteGeneral.service');
var TramiteEspecifico_1 = require('../../model/tramiteEspecifico/TramiteEspecifico');
var tramite_service_1 = require('../../services/tramite/tramite.service');
var variante_service_1 = require('../../services/variante/variante.service');
var caso_service_1 = require('../../services/caso/caso.service');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var TramiteEspecificoEditComponent = (function () {
    function TramiteEspecificoEditComponent(_TramiteService, _TramiteEspecificoService, _VarianteService, _CasoService, _TramiteGeneralService, _loginService, _route, _router) {
        this._TramiteService = _TramiteService;
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._VarianteService = _VarianteService;
        this._CasoService = _CasoService;
        this._TramiteGeneralService = _TramiteGeneralService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    TramiteEspecificoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, null, null, null, null, null);
        var token = this._loginService.getToken();
        this._TramiteService.getTramite().subscribe(function (response) {
            _this.Tramites = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._TramiteEspecificoService.showTramiteEspecifico(token, this.id).subscribe(function (response) {
            var data = response.data;
            _this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(data.id, data.tramite.id, data.tramiteGeneral.id, data.variante.id, data.caso.id, data.valor);
            console.log(_this.tramiteEspecifico);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._TramiteService.getTramite().subscribe(function (response) {
            _this.tramites = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._TramiteGeneralService.getTramiteGeneral().subscribe(function (response) {
            _this.tramitesGeneral = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VarianteService.getVariante().subscribe(function (response) {
            _this.variantes = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._CasoService.getCaso().subscribe(function (response) {
            _this.casos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    TramiteEspecificoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._TramiteEspecificoService.editTramiteEspecifico(this.tramiteEspecifico, token).subscribe(function (response) {
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
    TramiteEspecificoEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/tramiteEspecifico/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, tramite_service_1.TramiteService, tramiteGeneral_service_1.TramiteGeneralService, variante_service_1.VarianteService, caso_service_1.CasoService]
        }), 
        __metadata('design:paramtypes', [tramite_service_1.TramiteService, tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, caso_service_1.CasoService, tramiteGeneral_service_1.TramiteGeneralService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], TramiteEspecificoEditComponent);
    return TramiteEspecificoEditComponent;
}());
exports.TramiteEspecificoEditComponent = TramiteEspecificoEditComponent;
//# sourceMappingURL=edit.tramiteEspecifico.component.js.map
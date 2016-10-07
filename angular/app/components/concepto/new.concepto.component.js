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
var cuenta_service_1 = require("../../services/cuenta/cuenta.service");
var tramite_service_1 = require('../../services/tramite/tramite.service');
var concepto_service_1 = require("../../services/concepto/concepto.service");
var Concepto_1 = require('../../model/concepto/Concepto');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewConceptoComponent = (function () {
    function NewConceptoComponent(_CuentaService, _TramiteService, _ConceptoService, _loginService, _route, _router) {
        this._CuentaService = _CuentaService;
        this._TramiteService = _TramiteService;
        this._ConceptoService = _ConceptoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewConceptoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.concepto = new Concepto_1.Concepto(null, null, null, "", null);
        var token = this._loginService.getToken();
        this._TramiteService.getTramite().subscribe(function (response) {
            _this.tramites = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._CuentaService.getCuenta().subscribe(function (response) {
            _this.cuentas = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewConceptoComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ConceptoService.register(this.concepto, token).subscribe(function (response) {
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
    NewConceptoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/concepto/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, concepto_service_1.ConceptoService, tramite_service_1.TramiteService, cuenta_service_1.CuentaService]
        }), 
        __metadata('design:paramtypes', [cuenta_service_1.CuentaService, tramite_service_1.TramiteService, concepto_service_1.ConceptoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewConceptoComponent);
    return NewConceptoComponent;
}());
exports.NewConceptoComponent = NewConceptoComponent;
//# sourceMappingURL=new.concepto.component.js.map
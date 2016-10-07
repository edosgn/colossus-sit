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
var caso_service_1 = require("../../services/caso/caso.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var tramite_service_1 = require('../../services/tramite/tramite.service');
var caso_1 = require('../../model/caso/caso');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewCasoComponent = (function () {
    function NewCasoComponent(_TramiteService, _CasoService, _loginService, _route, _router) {
        this._TramiteService = _TramiteService;
        this._CasoService = _CasoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewCasoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.caso = new caso_1.Caso(null, null, "");
        this._TramiteService.getTramite().subscribe(function (response) {
            _this.tramites = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewCasoComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.caso);
        var token = this._loginService.getToken();
        this._CasoService.register(this.caso, token).subscribe(function (response) {
            _this.respuesta = response;
            console.log(_this.respuesta);
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    NewCasoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/caso/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, caso_service_1.CasoService, tramite_service_1.TramiteService]
        }), 
        __metadata('design:paramtypes', [tramite_service_1.TramiteService, (typeof (_a = typeof caso_service_1.CasoService !== 'undefined' && caso_service_1.CasoService) === 'function' && _a) || Object, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewCasoComponent);
    return NewCasoComponent;
    var _a;
}());
exports.NewCasoComponent = NewCasoComponent;
//# sourceMappingURL=new.caso.component.js.map
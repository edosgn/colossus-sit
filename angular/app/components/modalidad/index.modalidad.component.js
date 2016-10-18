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
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var modalidad_service_1 = require('../../services/modalidad/modalidad.service');
var router_1 = require("@angular/router");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexModalidadComponent = (function () {
    function IndexModalidadComponent(_ModalidadService, _loginService, _route, _router) {
        this._ModalidadService = _ModalidadService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    IndexModalidadComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ModalidadService.getModalidad().subscribe(function (response) {
            _this.modalidades = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexModalidadComponent.prototype.deleteModalidad = function (id) {
        var _this = this;
        var token = this._loginService.getToken();
        this._ModalidadService.deleteModalidad(token, id).subscribe(function (response) {
            _this.respuesta = response;
            _this.ngOnInit();
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexModalidadComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/modalidad/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, modalidad_service_1.ModalidadService]
        }), 
        __metadata('design:paramtypes', [modalidad_service_1.ModalidadService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexModalidadComponent);
    return IndexModalidadComponent;
}());
exports.IndexModalidadComponent = IndexModalidadComponent;
//# sourceMappingURL=index.modalidad.component.js.map
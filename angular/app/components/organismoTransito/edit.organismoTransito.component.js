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
var organismoTransito_service_1 = require('../../services/organismoTransito/organismoTransito.service');
var OrganismoTransito_1 = require('../../model/organismoTransito/OrganismoTransito');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var OrganismoTransitoEditComponent = (function () {
    function OrganismoTransitoEditComponent(_loginService, _OrganismoTransitoService, _route, _router) {
        this._loginService = _loginService;
        this._OrganismoTransitoService = _OrganismoTransitoService;
        this._route = _route;
        this._router = _router;
    }
    OrganismoTransitoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.organismoTransito = new OrganismoTransito_1.OrganismoTransito(null, "");
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._OrganismoTransitoService.showOrganismoTransito(token, this.id).subscribe(function (response) {
            _this.organismoTransito = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    OrganismoTransitoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._OrganismoTransitoService.editOrganismoTransito(this.organismoTransito, token).subscribe(function (response) {
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
    OrganismoTransitoEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/organismoTransito/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, organismoTransito_service_1.OrganismoTransitoService]
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService, organismoTransito_service_1.OrganismoTransitoService, router_1.ActivatedRoute, router_1.Router])
    ], OrganismoTransitoEditComponent);
    return OrganismoTransitoEditComponent;
}());
exports.OrganismoTransitoEditComponent = OrganismoTransitoEditComponent;
//# sourceMappingURL=edit.organismoTransito.component.js.map
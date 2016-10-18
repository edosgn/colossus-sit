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
var linea_service_1 = require("../../services/linea/linea.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var marca_service_1 = require('../../services/marca/marca.service');
var router_1 = require("@angular/router");
var linea_1 = require('../../model/linea/linea');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var LineaEditComponent = (function () {
    function LineaEditComponent(_MarcaService, _loginService, _LineaService, _route, _router) {
        this._MarcaService = _MarcaService;
        this._loginService = _loginService;
        this._LineaService = _LineaService;
        this._route = _route;
        this._router = _router;
    }
    LineaEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.linea = new linea_1.Linea(null, null, "", null);
        var token = this._loginService.getToken();
        this._MarcaService.getMarca().subscribe(function (response) {
            _this.marcas = response.data;
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
        this._LineaService.showLinea(token, this.id).subscribe(function (response) {
            var data = response.data;
            _this.linea = new linea_1.Linea(data.id, data.marca.id, data.nombre, data.codigoMt);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    LineaEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._LineaService.editLinea(this.linea, token).subscribe(function (response) {
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
    LineaEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/linea/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, linea_service_1.LineaService, marca_service_1.MarcaService]
        }), 
        __metadata('design:paramtypes', [marca_service_1.MarcaService, login_service_1.LoginService, linea_service_1.LineaService, router_1.ActivatedRoute, router_1.Router])
    ], LineaEditComponent);
    return LineaEditComponent;
}());
exports.LineaEditComponent = LineaEditComponent;
//# sourceMappingURL=edit.linea.component.js.map
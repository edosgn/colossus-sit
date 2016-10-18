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
var router_1 = require("@angular/router");
var marca_service_1 = require('../../services/marca/marca.service');
var linea_1 = require('../../model/linea/linea');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewLineaComponent = (function () {
    function NewLineaComponent(_MarcaService, _LineaService, _loginService, _route, _router) {
        this._MarcaService = _MarcaService;
        this._LineaService = _LineaService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewLineaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.linea = new linea_1.Linea(null, null, "", null);
        this._MarcaService.getMarca().subscribe(function (response) {
            _this.marcas = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewLineaComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.linea);
        var token = this._loginService.getToken();
        this._LineaService.register(this.linea, token).subscribe(function (response) {
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
    NewLineaComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/linea/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, linea_service_1.LineaService, marca_service_1.MarcaService]
        }), 
        __metadata('design:paramtypes', [marca_service_1.MarcaService, linea_service_1.LineaService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewLineaComponent);
    return NewLineaComponent;
}());
exports.NewLineaComponent = NewLineaComponent;
//# sourceMappingURL=new.linea.component.js.map
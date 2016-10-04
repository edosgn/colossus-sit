"use strict";
var router_1 = require('@angular/router');
var login_component_1 = require("./components/login.component");
var defaul_component_1 = require("./components/defaul.component");
var usuario_edit_component_1 = require("./components/usuario.edit.component");
var register_component_1 = require("./components/register.component");
var index_departamento_component_1 = require("./components/departamento/index.departamento.component");
var new_departamento_component_1 = require("./components/departamento/new.departamento.component");
var edit_departamento_component_1 = require("./components/departamento/edit.departamento.component");
var index_municipio_component_1 = require("./components/municipio/index.municipio.component");
var new_municipio_component_1 = require("./components/municipio/new.municipio.component");
var edit_municipio_component_1 = require("./components/municipio/edit.municipio.component");
var index_banco_component_1 = require("./components/banco/index.banco.component");
exports.routes = [
    {
        path: '',
        redirectTo: '/login',
        terminal: true
    },
    { path: 'index', component: defaul_component_1.DefaulComponent },
    { path: 'login', component: login_component_1.LoginComponent },
    { path: 'login/:id', component: login_component_1.LoginComponent },
    { path: 'registrar', component: register_component_1.RegisterComponent },
    { path: 'usuario-edit/:id', component: usuario_edit_component_1.UsuarioEditComponent },
    { path: 'departamento/index', component: index_departamento_component_1.IndexDepartamentoComponent },
    { path: 'departamento/new', component: new_departamento_component_1.NewDepartamentoComponent },
    { path: 'departamento/show/:id', component: edit_departamento_component_1.DepartamentoEditComponent },
    { path: 'municipio/index', component: index_municipio_component_1.IndexMunicipioComponent },
    { path: 'municipio/new', component: new_municipio_component_1.NewMunicipioComponent },
    { path: 'municipio/show/:id', component: edit_municipio_component_1.MunicipioEditComponent },
    { path: 'banco/index', component: index_banco_component_1.IndexBancoComponent },
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map
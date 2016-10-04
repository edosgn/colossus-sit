"use strict";
var router_1 = require('@angular/router');
var login_component_1 = require("./components/login.component");
var defaul_component_1 = require("./components/defaul.component");
var usuario_edit_component_1 = require("./components/usuario.edit.component");
var register_component_1 = require("./components/register.component");
var index_departamento_component_1 = require("./components/departamento/index.departamento.component");
var new_departamento_component_1 = require("./components/departamento/new.departamento.component");
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
    { path: 'departamento/new', component: new_departamento_component_1.NewDepartamentoComponent }
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map
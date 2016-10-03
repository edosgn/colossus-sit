"use strict";
var router_1 = require('@angular/router');
var login_component_1 = require("./components/login.component");
var defaul_component_1 = require("./components/defaul.component");
var usuario_edit_component_1 = require("./components/usuario.edit.component");
var index_departamento_component_1 = require("./components/index.departamento.component");
var register_component_1 = require("./components/register.component");
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
    { path: 'index/departamento', component: index_departamento_component_1.IndexDepartamentoComponent },
    { path: 'usuario-edit/:id', component: usuario_edit_component_1.UsuarioEditComponent }
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map
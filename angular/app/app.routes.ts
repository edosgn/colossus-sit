import { provideRouter, RouterConfig } from '@angular/router';
import { LoginComponent } from "./components/login.component";
import { DefaulComponent } from "./components/defaul.component";
import { UsuarioEditComponent } from "./components/usuario.edit.component";
import { IndexDepartamentoComponent } from "./components/index.departamento.component";
import { RegisterComponent } from "./components/register.component";



export const routes: RouterConfig = [
    {
    	path:'',
    	redirectTo: '/login',
    	terminal: true

    },
	{ path: 'index', component: DefaulComponent},
	{ path: 'login', component: LoginComponent},
	{ path: 'login/:id', component: LoginComponent},
	{ path: 'registrar', component: RegisterComponent},
    { path: 'index/departamento', component: IndexDepartamentoComponent},
    { path: 'usuario-edit/:id', component: UsuarioEditComponent}

];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
];
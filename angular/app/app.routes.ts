import { provideRouter, RouterConfig } from '@angular/router';
import { LoginComponent } from "./components/login.component";
import { RegisterComponent } from "./components/register.component";
import { DefaulComponent } from "./components/defaul.component";
import { UsuarioEditComponent } from "./components/usuario.edit.component";


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
    { path: 'usuario-edit/:id', component: UsuarioEditComponent}

];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
];
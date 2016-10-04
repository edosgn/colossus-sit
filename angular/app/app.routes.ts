import { provideRouter, RouterConfig } from '@angular/router';
import { LoginComponent } from "./components/login.component";
import { DefaulComponent } from "./components/defaul.component";
import { UsuarioEditComponent } from "./components/usuario.edit.component";
import { RegisterComponent } from "./components/register.component";
import { IndexDepartamentoComponent } from "./components/departamento/index.departamento.component";
import { NewDepartamentoComponent } from "./components/departamento/new.departamento.component";
import { DepartamentoEditComponent } from "./components/departamento/edit.departamento.component";




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
    { path: 'usuario-edit/:id', component: UsuarioEditComponent},
    { path: 'departamento/index', component: IndexDepartamentoComponent},
    { path: 'departamento/new', component: NewDepartamentoComponent},
    { path: 'departamento/show/:id', component: DepartamentoEditComponent}


];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
]; 